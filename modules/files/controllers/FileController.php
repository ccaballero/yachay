<?php

class Files_FileController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $file_url = $request->getParam('file');
        $files_model = Yeah_Adapter::getModel('files');
        $file = $files_model->findByResource($file_url);
        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        $resources_model = Yeah_Adapter::getModel('resources');
        $resource = $resources_model->findByIdent($file->resource);

        $this->view->resource = $resource;
        $this->view->file = $file;

        history('files/' . $resource->ident);
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $file_url = $request->getParam('file');
        $files_model = Yeah_Adapter::getModel('files');
        $file = $files_model->findByResource($file_url);
        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $file->description = $request->getParam('description');

            if ($file->isValid()) {
                $file->save();
                $session->messages->addMessage('La descripcion se modifico correctamente');
                $session->url = $file->resource;
                $this->_redirect($this->view->url(array('file' => $file->resource), 'files_file_view'));
            } else {
                foreach ($file->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->file = $file;

        history('files/' . $file->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        $breadcrumb['Archivo'] = $this->view->url(array('file' => $file->resource), 'files_file_view');
        breadcrumb($breadcrumb);
    }

	public function downloadAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $file_url = $request->getParam('file');
        $files_model = Yeah_Adapter::getModel('files');
        $file = $files_model->findByResource($file_url);
        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        header("HTTP/1.1 200 OK"); //mandamos codigo de OK
        header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
        header('Content-Type: ' . $file->mime);
        header('Content-Disposition: attachment; filename="' . $file->filename . '";');
        header('Content-Length: '. $file->size . '; ');
        ob_clean();
        flush();
        readfile($CONFIG->dirroot . '/media/files/' . $file->resource);
        exit;
    }
}
