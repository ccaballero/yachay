<?php

class Photos_PhotoController extends Yachay_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_photo = $request->getParam('photo');
        $model_photos = new Photos();
        $photo = $model_photos->findByResource($url_photo);
        $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($photo->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->photo = $photo;
        $this->view->tags = $tags;

        history('photos/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Fotografias'] = $this->view->url(array('filter' => 'photos'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_photos = new Photos();
        $model_tags = new Tags();

        $url_photo = $request->getParam('photo');
        $resource = $model_resources->findByIdent($url_photo);
        $photo = $model_photos->findByResource($url_photo);

        $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $photo->description = $request->getParam('description');

            if ($photo->isValid()) {
                // re-tagging
                $model_tags->tagging_resource($_tags, $request->getParam('tags'), $resource);

                $photo->save();
                $session->url = $photos->resource;

                $session->messages->addMessage('La descripción se modifico correctamente');
                $this->_redirect($this->view->url(array('photo' => $photo->resource), 'photos_photo_view'));
            } else {
                foreach ($photo->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->photo = $photo;
        $this->view->tags = implode(', ', $_tags);

        history('photos/' . $photo->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Fotografias'] = $this->view->url(array('filter' => 'photos'), 'resources_filtered');
        $breadcrumb['Fotografía'] = $this->view->url(array('photo' => $photo->resource), 'photos_photo_view');
        breadcrumb($breadcrumb);
    }

    /*public function downloadAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_photo = $request->getParam('photo');
        $model_photos = new Photos();
        $photo = $model_photos->findByResource($url_photo);
        $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($photo->resource);
        $this->requireContext($resource);

        header("HTTP/1.1 200 OK"); //mandamos codigo de OK
        header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
        //header('Content-Type: ' . $file->mime);
        //header('Content-Disposition: attachment; filename="' . $file->filename . '";');
        header('Content-Length: '. $photo->size . '; ');
        ob_clean();
        flush();
        readfile(APPLICATION_PATH . '/../public/media/photos/' . $photo->resource);
        exit;
    }*/

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_photos = new Photos();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_photo = $request->getParam('photo');
        $resource = $model_resources->findByIdent($url_photo);
        $photo = $model_photos->findByResource($url_photo);

        $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');
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

        unlink(APPLICATION_PATH. '/../public/media/photos/' . $photo->resource);

        $photo->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('La imagen ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_photos = new Photos();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_photo = $request->getParam('photo');
        $resource = $model_resources->findByIdent($url_photo);
        $photo = $model_photos->findByResource($url_photo);

        $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');

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

        unlink(APPLICATION_PATH. '/../public/media/photos/' . $photo->resource);

        $photo->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('La imagen ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }
}
