<?php

class Videos_ManagerController extends Yachay_Controller_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        $this->requirePermission('resources', array('new', 'view'));
        $this->requirePermission('videos', 'upload');
        $request = $this->getRequest();

        $video = new Videos_Empty();
        $tags = '';
        
        $model_videos = new Videos();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/data/upload/');
            $upload->addValidator('Size', false, 2097152)
                   ->addValidator('Extension', false, array('flv'));

            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yachay_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $this->_helper->flashMessenger->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('video');

                    $video = $model_videos->createRow();
                    $video->filename = basename($filename);
                    $video->size = filesize($filename);
                    $video->proportion = $request->getParam('proportion');
                    $video->description = $request->getParam('description');

                    if ($video->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $this->user->ident;
                        $resource->recipient = $publish;
                        $resource->tsregister = time();
                        $resource->save();

                        $video->resource = $resource->ident;
                        $video->save();

                        rename(APPLICATION_PATH . '/data/upload/' . $video->filename, APPLICATION_PATH . '/public/media/videos/' . $video->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(8);

                        // tagging
                        $model_tags->tagging_resource(array(), $tags, $resource);

                        $session->url = $video->resource;

                        $this->_helper->flashMessenger->addMessage('El video fue cargado exitosamente');
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($video->getMessages() as $message) {
                            $this->_helper->flashMessenger->addMessage($message);
                        }
                    }
                } else {
                    $this->_helper->flashMessenger->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
            } else {
                $this->_helper->flashMessenger->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        } else {
            $this->history('videos/new');
        }

        $this->view->video = $video;
        $this->view->tags = $tags;

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }
}
