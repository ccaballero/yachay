<?php

class Videos_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $CONFIG;
        global $USER;

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
            $session = new Zend_Session_Namespace();

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($CONFIG->dirroot . 'media/upload');
            $upload->addValidator('Size', false, 20971520);

            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $session->messages->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('video');
                    $extension = strtolower(substr($filename, -3));

                    $video = $model_videos->createRow();
                    $video->filename = basename($filename);
                    $video->size = filesize($filename);
                    $video->proportion = $request->getParam('proportion');
                    $video->description = $request->getParam('description');

                    if ($video->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $USER->ident;
                        $resource->recipient = $publish;
                        $resource->tsregister = time();
                        $resource->save();

                        $video->resource = $resource->ident;
                        $video->save();

                        rename($CONFIG->dirroot . 'media/upload/' . $video->filename, $CONFIG->dirroot . 'media/videos/' . $video->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(8);

                        // tagging
                        $model_tags->tagging_resource(array(), $tags, $resource);

                        $session->url = $video->resource;

                        $session->messages->addMessage('El video fue cargado exitosamente');
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($video->getMessages() as $message) {
                            $session->messages->addMessage($message);
                        }
                    }
                } else {
                    $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
            } else {
                $session->messages->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->video = $video;
        $this->view->tags = $tags;

        history('videos/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
