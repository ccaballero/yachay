<?php

class Files_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $file = new modules_files_models_Files_Empty();
        
        $files_model = Yeah_Adapter::getModel('files');
        $resources_model = Yeah_Adapter::getModel('resources');
        $valorations_model = Yeah_Adapter::getModel('valorations');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $upload = new Zend_File_Transfer_Adapter_Http(); 
            $upload->setDestination($CONFIG->dirroot . 'media/upload');
            $upload->addValidator('Size', false, 2097152);
             
            $publish = $request->getParam('publish');

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (in_array($publish, $spaces_valids)) {
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');
                    $extension = strtolower(substr($filename, -3));

                    $file = $files_model->createRow();
                    $file->filename = basename($filename);
                    $file->mime = mime_content_type($filename);
                    $file->size = filesize($filename);
                    $file->description = $request->getParam('description');

                    if ($file->isValid()) {
                        $resource = $resources_model->createRow();
                        $resource->author = $USER->ident;
                        $resource->recipient = $request->getParam('publish');
                        $resource->tsregister = time();
                        $resource->save();

                        $file->resource = $resource->ident;
                        $file->save();

                        rename($CONFIG->dirroot . 'media/upload/' . $file->filename, $CONFIG->dirroot . 'media/files/' . $file->resource);

                        $resource->saveContext($request);
                        $valorations_model->addActivity(2);

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
                $session->messages->addMessage("Usted no tiene privilegios para publicar en ese espacio");
            }
        }

        $this->view->file = $file;

        history('files/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}

