<?php

class Files_ManagerController extends Yachay_Controller_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $file = new Files_Empty();
        $tags = '';
        
        $model_files = new Files();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/data/upload/');
            $upload->addValidator('Size', false, 2097152);
             
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');

            $context = new Yachay_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $this->_helper->flashMessenger->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');

                    $file = $model_files->createRow();
                    $file->filename = basename($filename);
                    $file->mime = mime_content_type($filename);
                    $file->size = filesize($filename);
                    $file->description = $request->getParam('description');

                    if ($file->isValid()) {
                        $resource = $model_resources->createRow();
                        $resource->author = $this->user->ident;
                        $resource->recipient = $publish;
                        $resource->tsregister = time();
                        $resource->save();

                        $file->resource = $resource->ident;
                        $file->save();

                        rename(APPLICATION_PATH . '/../data/upload//' . $file->filename, APPLICATION_PATH . '/public/media/files/' . $file->resource);

                        $resource->saveContext($request);
                        $model_valorations->addActivity(2);

                        // tagging
                        $model_tags->tagging_resource(array(), $tags, $resource);

                        $session->url = $file->resource;

                        $this->_helper->flashMessenger->addMessage('El archivo fue cargado exitosamente');
                        $this->_redirect($request->getParam('return'));
                    } else {
                        foreach ($file->getMessages() as $message) {
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
            $this->history('files/new');
        }

        $this->view->file = $file;
        $this->view->tags = $tags;

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }
}
