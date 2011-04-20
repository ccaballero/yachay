<?php

class Files_FileController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_file = $request->getParam('file');
        $model_files = new Files();
        $file = $model_files->findByResource($url_file);
        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($file->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->file = $file;
        $this->view->tags = $tags;

        history('files/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Archivos'] = $this->view->url(array('filter' => 'files'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_files = new Files();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        $url_file = $request->getParam('file');
        $resource = $model_resources->findByIdent($url_file);
        $file = $model_files->findByResource($url_file);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
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
                $saved_tags = array();

                // removing duplicates tags
                foreach ($newTags as $new_tag) {
                    $new_tag = trim(strtolower($new_tag));
                    if (!in_array($new_tag, $saved_tags)) {
                        $saved_tags[] = $new_tag;
                    }
                }

                for ($i = 0; $i < count($saved_tags); $i++) {
                    for ($j = 0; $j < count($oldTags); $j++) {
                        if (isset($saved_tags[$i]) && isset($oldTags[$j])) {
                            if ($saved_tags[$i] == $oldTags[$j]) {
                                $saved_tags[$i] = NULL;
                                $oldTags[$j] = NULL;
                            }
                        }
                    }
                }
                foreach ($saved_tags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tagLabel = trim(strtolower($tagLabel));
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
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $model_tags->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

                $session->messages->addMessage('La descripción se modifico correctamente');
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

        $url_file = $request->getParam('file');
        $model_files = new Files();
        $file = $model_files->findByResource($url_file);
        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($file->resource);
        $this->requireContext($resource);

        $file->downloads = $file->downloads + 1;
        $file->save();

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

        $model_resources = new Resources();
        $model_files = new Files();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_file = $request->getParam('file');
        $resource = $model_resources->findByIdent($url_file);
        $file = $model_files->findByResource($url_file);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/files/' . $file->resource);

        $file->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El archivo ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_files = new Files();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_file = $request->getParam('file');
        $resource = $model_resources->findByIdent($url_file);
        $file = $model_files->findByResource($url_file);

        $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');

        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/files/' . $file->resource);

        $file->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El archivo ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }
}
