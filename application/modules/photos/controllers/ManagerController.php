<?php

class Photos_ManagerController extends Yachay_Action
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

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/../public/media/upload');
            $upload->addValidator('Size', false, 2097152);
             
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yachay_Helpers_Context();
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

                        $thumbnail = new Yachay_Helpers_Thumbnail();
                        $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/photos/' . $photo->resource . '.thumb', 300, 300);

                        rename(APPLICATION_PATH . '/../public/media/upload/' . $photo->filename, APPLICATION_PATH . '/../public/media/photos/' . $photo->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(2);

                        // tagging
                        $model_tags->tagging_resource(array(), $tags, $resource);

                        $session->url = $photo->resource;

                        $session->messages->addMessage('La imagen fue cargada exitosamente');
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
