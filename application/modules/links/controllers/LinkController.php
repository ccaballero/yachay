<?php

class Links_LinkController extends Yachay_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_link = $request->getParam('link');
        $model_links = new Links();
        $link = $model_links->findByResource($url_link);
        $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($link->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->link = $link;
        $this->view->tags = $tags;

        $this->history('links/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Enlaces'] = $this->view->url(array('filter' => 'links'), 'resources_filtered');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_links = new Links();
        $model_tags = new Tags();

        $url_link = $request->getParam('link');
        $resource = $model_resources->findByIdent($url_link);
        $link = $model_links->findByResource($url_link);

        $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');
            $link->link = $request->getParam('link_link');
            $link->description = $request->getParam('description');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $link->priority = false;
            } else {
                $link->priority = true;
            }

            if ($link->isValid()) {
                // re-tagging
                $model_tags->tagging_resource($_tags, $request->getParam('tags'), $resource);

                $link->save();
                $session->url = $link->resource;

                $this->_helper->flashMessenger->addMessage('El enlace se modifico correctamente');
                $this->_redirect($this->view->url(array('link' => $link->resource), 'links_link_view'));
            } else {
                foreach ($link->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        }

        $this->view->link = $link;
        $this->view->tags = implode(', ', $_tags);

        $this->history('links/' . $link->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Enlaces'] = $this->view->url(array('filter' => 'links'), 'resources_filtered');
        $breadcrumb['Enlace'] = $this->view->url(array('link' => $link->resource), 'links_link_view');
        $this->breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_links = new Links();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_link = $request->getParam('link');
        $resource = $model_resources->findByIdent($url_link);
        $link = $model_links->findByResource($url_link);

        $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');
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

        $link->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(1);

        $this->_helper->flashMessenger->addMessage('El enlace ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_links = new Links();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_link = $request->getParam('link');
        $resource = $model_resources->findByIdent($url_link);
        $link = $model_links->findByResource($url_link);

        $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');

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

        $link->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(1, $resource->author);

        $this->_helper->flashMessenger->addMessage('El enlace ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }
}
