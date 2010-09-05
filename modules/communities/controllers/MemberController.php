<?php

class Communities_MemberController extends Yeah_Action
{
    public function lockAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $communities_model = Yeah_Adapter::getModel('communities');
        $users_model = Yeah_Adapter::getModel('users');

        $community_url = $request->getParam('community');
        $user_url = $request->getParam('user');

        $community = $communities_model->findByUrl($community_url);
        $user = $users_model->findByUrl($user_url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        $session = new Zend_Session_Namespace();

        if ($community->author == $user->ident) {
            $session->messages->addMessage('El usuario ' . $user->label . ' no puede ser deshabilitado de la comunidad');
        } else {
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');
            $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
            $assign->status = 'inactive';
            $assign->save();

            $session->messages->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $communities_model = Yeah_Adapter::getModel('communities');
        $users_model = Yeah_Adapter::getModel('users');

        $community_url = $request->getParam('community');
        $user_url = $request->getParam('user');

        $community = $communities_model->findByUrl($community_url);
        $user = $users_model->findByUrl($user_url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        $session = new Zend_Session_Namespace();

        if ($community->author == $user->ident) {
            $session->messages->addMessage('El usuario ' . $user->label . ' no puede ser habilitado de la comunidad');
        } else {
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');
            $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
            $assign->status = 'active';
            $assign->save();

            $session->messages->addMessage('El usuario ' . $user->label . ' ha sido habilitado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $communities_model = Yeah_Adapter::getModel('communities');
        $users_model = Yeah_Adapter::getModel('users');

        $community_url = $request->getParam('community');
        $user_url = $request->getParam('user');

        $community = $communities_model->findByUrl($community_url);
        $user = $users_model->findByUrl($user_url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        $session = new Zend_Session_Namespace();

        if ($community->author == $user->ident) {
            $session->messages->addMessage('El usuario ' . $user->label . ' no puede ser retirado de la comunidad');
        } else {
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');
            $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
            $assign->delete();

            $community->members = $community->members - 1;
            $community->save();

            $session->messages->addMessage('El usuario ' . $user->label . ' ha sido retirado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }
}
