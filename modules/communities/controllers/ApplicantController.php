<?php

class Communities_ApplicantController extends Yeah_Action
{
    public function acceptAction() {
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

        $communities_users_model = Yeah_Adapter::getModel('communities', 'Communities_Users');
        $row = $communities_users_model->createRow();
        $row->community = $community->ident;
        $row->user = $user->ident;
        $row->type = 'member';
        $row->status = 'active';
        $row->tsregister = time();
        $row->save();

        $communities_petitions_model = Yeah_Adapter::getModel('communities', 'Communities_Petitions');
        $row = $communities_petitions_model->findByCommunityAndUser($community->ident, $user->ident);
        $row->delete();

        $community->members = $community->members + 1;
        $community->petitions = $community->petitions - 1;
        $community->save();

        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido aceptado en la comunidad');

        $this->_redirect($this->view->currentPage());
    }

    public function declineAction() {
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

        $communities_petitions_model = Yeah_Adapter::getModel('communities', 'Communities_Petitions');
        $row = $communities_petitions_model->findByCommunityAndUser($community->ident, $user->ident);
        $row->delete();

        $community->petitions = $community->petitions - 1;
        $community->save();

        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido rechazado de la comunidad');

        $this->_redirect($this->view->currentPage());
    }
}
