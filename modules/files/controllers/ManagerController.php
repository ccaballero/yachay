<?php

class Files_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $file = new Files_Empty();
        $tags = '';
        
        $model_files = new Files();
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
                    $filename = $upload->getFileName('file');
                    $extension = strtolower(substr($filename, -3));

                    $file = $model_files->createRow();
                    $file->filename = basename($filename);
                    $file->mime = mime_content_type($filename);
                    $file->size = filesize($filename);
                    $file->description = $request->getParam('description');

                    if ($file->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $USER->ident;
                        $resource->recipient = $request->getParam('publish');
                        $resource->tsregister = time();
                        $resource->save();

                        $file->resource = $resource->ident;
                        $file->save();

                        rename($CONFIG->dirroot . 'media/upload/' . $file->filename, $CONFIG->dirroot . 'media/files/' . $file->resource);

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

                        $session->messages->addMessage('El archivo fue cargado exitosamente');
                        $session->url = $file->resource;
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($note->getMessages() as $message) {
                            $session->messages->addMessage($message);
                        }
                    }
                }
            } else {
                $session->messages->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->file = $file;
        $this->view->tags = $tags;

        history('files/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
