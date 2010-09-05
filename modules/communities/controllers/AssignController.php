<?php

class Communities_AssignController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'view');

        $request = $this->getRequest();
        $model_communities = Yeah_Adapter::getModel('communities');
        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);
        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        if ($request->isPost()) {
            if ($community->amModerator()) {
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
            }
            if ($community->amAuthor()) {
                $moderate = $request->getParam('moderate');
                $unmoderate = $request->getParam('unmoderate');
                if (!empty($moderate)) {
                    $this->_forward('moderate');
                } else if (!empty($unmoderate)) {
                    $this->_forward('unmoderate');
                }
            }
        }

        context('community', $community);

        $moderators = $community->findmodules_users_models_UsersViamodules_communities_models_Communities_Users($community->select()->where('type = ?', 'moderator'));
        $members = $community->findmodules_users_models_UsersViamodules_communities_models_Communities_Users($community->select()->where('type = ?', 'member'));

        $this->view->model = $model_communities;
        $this->view->community = $community;
        $this->view->moderators = $moderators;
        $this->view->members = $members;

        history('communities/' . $community->url . '/assign');
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

    public function lockAction() {
        global $USER;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = Yeah_Adapter::getModel('users');
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $USER->ident <> $user->ident) {
                    $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->status = 'inactive';
                    $assign->save();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han deshabilitado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        global $USER;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = Yeah_Adapter::getModel('users');
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $USER->ident <> $user->ident) {
                    $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->status = 'active';
                    $assign->save();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han habilitado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = Yeah_Adapter::getModel('users');
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $USER->ident <> $user->ident) {
                    $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->delete();
                    $count++;
                }
            }

            $community->members = $community->members - $count;
            $community->save();

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han retirado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function moderateAction() {
        global $USER;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = Yeah_Adapter::getModel('users');
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $USER->ident <> $user->ident) {
                    $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->type = 'moderator';
                    $assign->save();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han convertido a $count miembros en moderadores");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unmoderateAction() {
        global $USER;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = Yeah_Adapter::getModel('users');
            $assignement = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $USER->ident <> $user->ident) {
                    $assign = $assignement->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->type = 'member';
                    $assign->save();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han convertido a $count miembros en miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function joinAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $url = $request->getParam('community');
        $communities_model = Yeah_Adapter::getModel('communities');
        $community = $communities_model->findByUrl($url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        if ($community->mode == 'open') {
            $communities_users_model = Yeah_Adapter::getModel('communities', 'Communities_Users');
            $assignement = $communities_users_model->findByCommunityAndUser($community->ident, $USER->ident);
            $session = new Zend_Session_Namespace();
            if ($assignement == NULL) {
                $row = $communities_users_model->createRow();
                $row->community = $community->ident;
                $row->user = $USER->ident;
                $row->type = 'member';
                $row->status = 'active';
                $row->tsregister = time();
                $row->save();
                $community->members = $community->members + 1;
                $community->save();
                $session->messages->addMessage("Tu te has unido a la comunidad {$community->label}");
            } else {
                $session->messages->addMessage("Tu ya perteneces a esta comunidad");
            }
        }
        if ($community->mode == 'close') {
            $communities_petitions_model = Yeah_Adapter::getModel('communities', 'Communities_Petitions');
            $assignement = $communities_petitions_model->findByCommunityAndUser($community->ident, $USER->ident);
            $session = new Zend_Session_Namespace();
            if ($assignement == NULL) {
                $row = $communities_petitions_model->createRow();
                $row->community = $community->ident;
                $row->user = $USER->ident;
                $row->tsregister = time();
                $row->save();
                $community->petitions = $community->petitions + 1;
                $community->save();
                $session->messages->addMessage("Tu solicitud de ingreso a la comunidad {$community->label} ha sido enviada");
            } else {
                $session->messages->addMessage("Tu ya has solicitado el ingreso a esta comunidad");
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function leaveAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $url = $request->getParam('community');
        $communities_model = Yeah_Adapter::getModel('communities');
        $community = $communities_model->findByUrl($url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        $communities_users_model = Yeah_Adapter::getModel('communities', 'Communities_Users');
        $assignement = $communities_users_model->findByCommunityAndUser($community->ident, $USER->ident);
        $session = new Zend_Session_Namespace();
        if ($assignement <> NULL) {
            $assignement->delete();
            $community->members = $community->members - 1;
            $community->save();
            $session->messages->addMessage("Tu has dejado la communidad {$community->label}");
        } else {
            $session->messages->addMessage("Tu no perteneces a&uacute;n a esa comunidad");
        }

        $this->_redirect($this->view->currentPage());
    }
}
