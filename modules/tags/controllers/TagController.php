<?php

class Tags_TagController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('tags', 'list');

        $request = $this->getRequest();
        $tags_model = Yeah_Adapter::getModel('tags');
        $tagLabel = $request->getParam('tag');
        $tag = $tags_model->findByUrl($tagLabel);

        if ($tag == NULL) {
            $tag = $tags_model->createRow();
            $tag->label = $tagLabel;
        }

        // Fetch all posts in system!!
        $context = new Yeah_Helpers_Context;
        $list_spaces = $context->context(NULL, 'plain');

        $resources = $tag->findmodules_resources_models_ResourcesViamodules_tags_models_Tags_Resources($tag->select()->order('tsregister DESC'));
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
        $this->view->resources = $paginator;
        $this->view->communities = $tag->findmodules_communities_models_CommunitiesViamodules_tags_models_Tags_Communities($tag->select()->order('tsregister DESC'));
        $this->view->users = $tag->findmodules_users_models_UsersViamodules_tags_models_Tags_Users($tag->select()->order('tsregister DESC'));
        $this->view->route = array (
            'key' => 'tags_list',
            'params' => array(),
        );

        history('tags/' . $tag->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('tags', 'list')) {
            $breadcrumb['Etiquetas'] = $this->view->url(array(), 'tags_list');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('tags', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('tag');

        $model_tags = Yeah_Adapter::getModel('tags');
        $model_tags_resources = Yeah_Adapter::getModel('tags', 'Tags_Resources');
        $model_tags_communities = Yeah_Adapter::getModel('tags', 'Tags_Communities');
        $model_tags_users = Yeah_Adapter::getModel('tags', 'Tags_Users');

        $tag = $model_tags->findByUrl($url);

        $session = new Zend_Session_Namespace();
        if (!empty($tag)) {
            $label = $tag->label;

            $model_tags_resources->deleteResourcesInTag($tag->ident);
            $model_tags_communities->deleteCommunitiesInTag($tag->ident);
            $model_tags_users->deleteUsersInTag($tag->ident);

            $tag->delete();
            $session->messages->addMessage("La etiqueta $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La etiqueta no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
