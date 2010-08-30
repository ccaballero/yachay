<?php

class Communities_AssignController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'view');

        $request = $this->getRequest();
        if ($request->isPost()) {
            /*if (Yeah_Acl::hasPermission('subjects', 'moderate')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }*/
        }

        $model_communities = Yeah_Adapter::getModel('communities');
        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);
        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        context('communities', $community);

        $moderators = $community->findmodules_users_models_UsersViamodules_communities_models_Communities_Users($community->select()->where('type = ?', 'moderator'));
        $members = $community->findmodules_users_models_UsersViamodules_communities_models_Communities_Users($community->select()->where('type = ?', 'member'));

        $this->view->model = $model_communities;
        $this->view->community = $community;
        $this->view->moderators = $moderators;
        $this->view->members = $members;

        history('community/' . $community->url . '/assign');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('communities', array('enter'))) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        } else if (Yeah_Acl::hasPermission('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if (Yeah_Acl::hasPermission('communities', 'view')) {
            $breadcrumb[$community->label] = $this->view->url(array('community' => $community->url), 'communities_community_view');
        }
        breadcrumb($breadcrumb);
    }
}
