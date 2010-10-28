<?php

class Tags_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('tags', 'list');
        $this->requirePermission('tags', 'delete');

        $model_tags = Yeah_Adapter::getModel('tags');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        }

        $this->view->model = $model_tags;
        $this->view->tags = $model_tags->selectAll();

        history('tags/manager');
        breadcrumb();
    }

    public function deleteAction() {
        $this->requirePermission('tags', 'delete');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_tags = Yeah_Adapter::getModel('tags');
            $model_tags_resources = Yeah_Adapter::getModel('tags', 'Tags_Resources');
            $model_tags_communities = Yeah_Adapter::getModel('tags', 'Tags_Communities');
            $model_tags_users = Yeah_Adapter::getModel('tags', 'Tags_Users');

            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $tag = $model_tags->findByIdent($value);
                if (!empty($tag)) {
                    $model_tags_resources->deleteResourcesInTag($tag->ident);
                    $model_tags_communities->deleteCommunitiesInTag($tag->ident);
                    $model_tags_users->deleteUsersInTag($tag->ident);

                    $tag->delete();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count etiquetas");
        }
        $this->_redirect($this->view->currentPage());
    }
}
