<?php

class Communities_MemberController extends Yachay_Controller_Action
{
    public function lockAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $model_communities = new Communities();
        $users_model = new Users();

        $url_community = $request->getParam('community');
        $url_user = $request->getParam('user');

        $community = $model_communities->findByUrl($url_community);
        $user = $users_model->findByUrl($url_user);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        if ($community->author == $user->ident) {
            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' no puede ser deshabilitado de la comunidad');
        } else {
            $model_communities_users = new Communities_Users();
            $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
            $assign->status = 'inactive';
            $assign->save();

            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $model_communities = new Communities();
        $users_model = new Users();

        $url_community = $request->getParam('community');
        $url_user = $request->getParam('user');

        $community = $model_communities->findByUrl($url_community);
        $user = $users_model->findByUrl($url_user);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        if ($community->author == $user->ident) {
            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' no puede ser habilitado de la comunidad');
        } else {
            $model_communities_users = new Communities_Users();
            $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
            $assign->status = 'active';
            $assign->save();

            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido habilitado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $model_communities = new Communities();
        $users_model = new Users();

        $url_community = $request->getParam('community');
        $url_user = $request->getParam('user');

        $community = $model_communities->findByUrl($url_community);
        $user = $users_model->findByUrl($url_user);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireCommunityModerator($community);

        if ($community->author == $user->ident) {
            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' no puede ser retirado de la comunidad');
        } else {
            $model_communities_users = new Communities_Users();
            $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
            $assign->delete();

            $community->members = $community->members - 1;
            $community->save();

            $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido retirado de la comunidad');
        }
        $this->_redirect($this->view->currentPage());
    }
}
