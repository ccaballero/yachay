<?php

class Photos_ManagerController extends Yachay_Controller_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $photo = new Photos_Empty();
        $tags = '';
        
        $model_photos = new Photos();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/../data/upload/');
            $upload->addValidator('Size', false, 2097152);
             
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yachay_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $this->_helper->flashMessenger->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('photo');

                    $photo = $model_photos->createRow();
                    $photo->filename = basename($filename);
                    $photo->size = filesize($filename);
                    $photo->description = $request->getParam('description');

                    if ($photo->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $this->user->ident;
                        $resource->recipient = $publish;
                        $resource->tsregister = time();
                        $resource->save();

                        $photo->resource = $resource->ident;
                        $photo->save();

                        $thumbnail = new Yachay_Helpers_Thumbnail();
                        $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/photos/' . $photo->resource . '.thumb', 300, 300);

                        rename(APPLICATION_PATH . '/../data/upload//' . $photo->filename, APPLICATION_PATH . '/../public/media/photos/' . $photo->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(2);

                        // tagging
                        $model_tags->tagging_resource(array(), $tags, $resource);

                        $session->url = $photo->resource;

                        $this->_helper->flashMessenger->addMessage('La imagen fue cargada exitosamente');
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($photo->getMessages() as $message) {
                            $this->_helper->flashMessenger->addMessage($message);
                        }
                    }
                } else {
                    $this->_helper->flashMessenger->addMessage('Debe escoger una imagen valida para poder interpretarla adecuadamente');
                }
            } else {
                $this->_helper->flashMessenger->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->photo = $photo;
        $this->view->tags = $tags;

        $this->history('photos/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Fotografias'] = $this->view->url(array('filter' => 'photos'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }
}
