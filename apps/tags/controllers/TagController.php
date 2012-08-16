<?php

class Tags_TagController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('tags', 'list');

        $request = $this->getRequest();

        $model_tags = new Tags();

        $url_tag = $request->getParam('tag');
        $tag = $model_tags->findByUrl($url_tag);

        if ($tag == NULL) {
            $tag = $model_tags->createRow();
            $tag->label = $url_tag;
        }

        // Fetch all posts in system!!
        $context = new Yachay_Helpers_Context;
        $list_spaces = $context->context(NULL, 'plain');

        $resources = $tag->findResourcesViaTags_Resources($tag->select()->order('tsregister DESC'));
        $_resources = array();
        foreach ($resources as $resource) {
            if (in_array($resource->recipient, $list_spaces)) {
                $_resources[] = $resource;
            }
        }

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($_resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->tag = $tag;
        $this->view->model_friends = new Friends();
        $this->view->resources = $paginator;
        $this->view->communities = $tag->findCommunitiesViaTags_Communities($tag->select()->order('tsregister DESC'));
        $this->view->users = $tag->findUsersViaTags_Users($tag->select()->order('tsregister DESC'));
        $this->view->pager = array (
            'key' => 'tags_list',
            'params' => array(),
        );

        $this->history('tags/' . $tag->url);
        $breadcrumb = array();
        if ($this->acl('tags', 'list')) {
            $breadcrumb['Etiquetas'] = $this->view->url(array(), 'tags_list');
        }
        if ($this->acl('tags', 'delete')) {
            $breadcrumb['Administrador de etiquetas'] = $this->view->url(array(), 'tags_manager');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('tags', 'delete');
        $request = $this->getRequest();

        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();
        $model_tags_communities = new Tags_Communities();
        $model_tags_users = new Tags_Users();

        $url_tag = $request->getParam('tag');
        $tag = $model_tags->findByUrl($url_tag);

        if (!empty($tag)) {
            $label = $tag->label;

            $model_tags_resources->deleteResourcesInTag($tag->ident);
            $model_tags_communities->deleteCommunitiesInTag($tag->ident);
            $model_tags_users->deleteUsersInTag($tag->ident);

            $tag->delete();
            $this->_helper->flashMessenger->addMessage("La etiqueta $label ha sido eliminada");
        } else {
            $this->_helper->flashMessenger->addMessage('La etiqueta no puede ser eliminada');
        }

        $this->_redirect($this->view->currentPage());
    }
}
