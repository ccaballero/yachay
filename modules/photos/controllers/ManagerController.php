<?php

class Photos_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $photo = new Photos_Empty();
        $tags = '';
        
        $model_photos = new Photos();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($CONFIG->dirroot . 'media/upload');
            $upload->addValidator('Size', false, 2097152);
             
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $session->messages->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('photo');
                    $extension = strtolower(substr($filename, -3));

                    $photo = $model_photos->createRow();
                    $photo->filename = basename($filename);
                    $photo->size = filesize($filename);
                    $photo->description = $request->getParam('description');

                    if ($photo->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $USER->ident;
                        $resource->recipient = $publish;
                        $resource->tsregister = time();
                        $resource->save();

                        $photo->resource = $resource->ident;
                        $photo->save();

                        $thumbnail = new Yeah_Helpers_Thumbnail();
                        $thumbnail->thumbnail($filename, $CONFIG->dirroot . 'media/photos/' . $photo->resource . '.thumb', 300, 300);

                        rename($CONFIG->dirroot . 'media/upload/' . $photo->filename, $CONFIG->dirroot . 'media/photos/' . $photo->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(2);

                        // TAG REGISTER
                        $tags = explode(',', $tags);
                        $saved_tags = array();

                        foreach ($tags as $tagLabel) {
                            $tagLabel = trim(strtolower($tagLabel));

                            if (!in_array($tagLabel, $saved_tags)) {
                                $tag = $model_tags->findByLabel($tagLabel);
                                if ($tag == NULL) {
                                    $tag = $model_tags->createRow();
                                    $tag->label = $tagLabel;
                                    $tag->url = convert($tag->label);
                                    $tag->weight = 1;
                                    if ($tag->isValid()) {
                                        $tag->tsregister = time();
                                        $tag->save();
                                    }
                                } else {
                                    $tag->weight = $tag->weight + 1;
                                    $tag->save();
                                }

                                if ($tag->ident <> 0) {
                                    $assign = $model_tags_resources->createRow();
                                    $assign->tag = $tag->ident;
                                    $assign->resource = $resource->ident;
                                    $assign->save();
                                }

                                $saved_tags[] = $tagLabel;
                            }
                        }

                        $session->messages->addMessage('La imagen fue cargada exitosamente');
                        $session->url = $photo->resource;
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($photo->getMessages() as $message) {
                            $session->messages->addMessage($message);
                        }
                    }
                } else {
                    $session->messages->addMessage('Debe escoger una imagen valida para poder interpretarla adecuadamente');
                }
            } else {
                $session->messages->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->photo = $photo;
        $this->view->tags = $tags;

        history('photos/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Fotografias'] = $this->view->url(array('filter' => 'photos'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
