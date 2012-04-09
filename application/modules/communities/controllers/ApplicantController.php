<?php

class Communities_ApplicantController extends Yachay_Action
{
    public function acceptAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $model_communities = new Communities();
        $model_users = new Users();

        $url_community = $request->getParam('community');
        $url_user = $request->getParam('user');

        $community = $model_communities->findByUrl($url_community);
        $user = $model_users->findByUrl($url_user);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        $session = new Zend_Session_Namespace();

        $model_communities_users = new Communities_Users();
        $row = $model_communities_users->createRow();
        $row->community = $community->ident;
        $row->user = $user->ident;
        $row->type = 'member';
        $row->status = 'active';
        $row->tsregister = time();
        $row->save();

        $model_communities_petitions = new Communities_Petitions();
        $row = $model_communities_petitions->findByCommunityAndUser($community->ident, $user->ident);
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
        $model_communities = new Communities();
        $model_users = new Users();

        $url_community = $request->getParam('community');
        $url_user = $request->getParam('user');

        $community = $model_communities->findByUrl($url_community);
        $user = $model_users->findByUrl($url_user);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        $session = new Zend_Session_Namespace();

        $model_communities_petitions = new Communities_Petitions();
        $row = $model_communities_petitions->findByCommunityAndUser($community->ident, $user->ident);
        $row->delete();

        $community->petitions = $community->petitions - 1;
        $community->save();

        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido rechazado de la comunidad');

        $this->_redirect($this->view->currentPage());
    }
}
