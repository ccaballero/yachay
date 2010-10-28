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
        $this->requireContext($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();

        $this->view->resource = $resource;
        $this->view->file = $file;
        $this->view->tags = $tags;

        history('files/' . $resource->ident);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $file_ident = $request->getParam('file');

        $resources_model = Yeah_Adapter::getModel('resources');
        $files_model = Yeah_Adapter::getModel('files');
        $tags_model = Yeah_Adapter::getModel('tags');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($file_ident);
        $file = $files_model->findByResource($file_ident);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $file->description = $request->getParam('description');
            $newTags = $request->getParam('tags');

            if ($file->isValid()) {
                $file->save();

                $newTags = explode(',', $newTags);
                $oldTags = $_tags;

                for ($i = 0; $i < count($newTags); $i++) {
                    for ($j = 0; $j < count($oldTags); $j++) {
                        if (isset($newTags[$i]) && isset($oldTags[$j])) {
                            if (trim(strtolower($newTags[$i])) == $oldTags[$j]) {
                                $newTags[$i] = NULL;
                                $oldTags[$j] = NULL;
                            }
                        }
                    }
                }
                foreach ($newTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tagLabel = trim(strtolower($tagLabel));
                        $tag = $tags_model->findByLabel($tagLabel);
                        if ($tag == NULL) {
                            $tag = $tags_model->createRow();
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
                            $assign = $tags_resources_model->createRow();
                            $assign->tag = $tag->ident;
                            $assign->resource = $resource->ident;
                            $assign->save();
                        }
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $tags_model->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

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
        $this->view->tags = implode(', ', $_tags);

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

        $resources_model = Yeah_Adapter::getModel('resources');
        $resource = $resources_model->findByIdent($file->resource);
        $this->requireContext($resource);

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

    public function deleteAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $file_ident = $request->getParam('file');

        $resources_model = Yeah_Adapter::getModel('resources');
        $files_model = Yeah_Adapter::getModel('files');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($file_ident);
        $file = $files_model->findByResource($file_ident);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/files/' . $file->resource);

        $file->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(2);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El archivo ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $file_ident = $request->getParam('file');

        $resources_model = Yeah_Adapter::getModel('resources');
        $files_model = Yeah_Adapter::getModel('files');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($file_ident);
        $file = $files_model->findByResource($file_ident);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/files/' . $file->resource);

        $file->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(2, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El archivo ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }
}
