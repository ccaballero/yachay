<?php

class Communities_AssignController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'view');
        $request = $this->getRequest();

        $model_communities = new Communities();

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
        } else {
            $this->history('communities/' . $community->url . '/assign');
        }

        $this->context('community', $community);

        $moderators = $community->findUsersViaCommunities_Users($community->select()->where('type = ?', 'moderator'));
        $members = $community->findUsersViaCommunities_Users($community->select()->where('type = ?', 'member'));

        $this->view->model_communities = $model_communities;
        $this->view->community = $community;
        $this->view->moderators = $moderators;
        $this->view->members = $members;

        $breadcrumb = array();
        if ($this->acl('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if ($this->acl('communities', 'enter')) {
            $breadcrumb['Administrador de comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        if ($this->acl('communities', 'view')) {
            $breadcrumb[$community->label] = $this->view->url(array('community' => $community->url), 'communities_community_view');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);

            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $this->user->ident <> $user->ident) {
                    $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->status = 'inactive';
                    $assign->save();
                    $count++;
                }
            }

            $this->_helper->flashMessenger->addMessage("Se han deshabilitado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);

            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $this->user->ident <> $user->ident) {
                    $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->status = 'active';
                    $assign->save();
                    $count++;
                }
            }

            $this->_helper->flashMessenger->addMessage("Se han habilitado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);

            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $this->user->ident <> $user->ident) {
                    $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->delete();
                    $count++;
                }
            }

            $community->members = $community->members - $count;
            $community->save();

            $this->_helper->flashMessenger->addMessage("Se han retirado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function moderateAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);

            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $this->user->ident <> $user->ident) {
                    $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->type = 'moderator';
                    $assign->save();
                    $count++;
                }
            }

            $this->_helper->flashMessenger->addMessage("Se han convertido a $count miembros en moderadores");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unmoderateAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);

            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();

            $members = $request->getParam("members");
            $count = 0;

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user) && $community->author <> $user->ident && $this->user->ident <> $user->ident) {
                    $assign = $model_communities_users->findByCommunityAndUser($community->ident, $user->ident);
                    $assign->type = 'member';
                    $assign->save();
                    $count++;
                }
            }

            $this->_helper->flashMessenger->addMessage("Se han convertido a $count miembros en miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function joinAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $model_communities = new Communities();

        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        if ($community->mode == 'open') {
            $model_communities_users = new Communities_Users();
            $assignement = $model_communities_users->findByCommunityAndUser($community->ident, $this->user->ident);

            $session = new Zend_Session_Namespace('yachay');
            if ($assignement == NULL) {
                $row = $model_communities_users->createRow();
                $row->community = $community->ident;
                $row->user = $this->user->ident;
                $row->type = 'member';
                $row->status = 'active';
                $row->tsregister = time();
                $row->save();
                $community->members = $community->members + 1;
                $community->save();

                $this->_helper->flashMessenger->addMessage("Tu te has unido a la comunidad {$community->label}");
            } else {
                $this->_helper->flashMessenger->addMessage('Tu ya perteneces a esta comunidad');
            }
        }
        if ($community->mode == 'close') {
            $model_communities_petitions = new Communities_Petitions();
            $assignement = $model_communities_petitions->findByCommunityAndUser($community->ident, $this->user->ident);

            $session = new Zend_Session_Namespace('yachay');
            if ($assignement == NULL) {
                $row = $model_communities_petitions->createRow();
                $row->community = $community->ident;
                $row->user = $this->user->ident;
                $row->tsregister = time();
                $row->save();
                $community->petitions = $community->petitions + 1;
                $community->save();

                $this->_helper->flashMessenger->addMessage("Tu solicitud de ingreso a la comunidad {$community->label} ha sido enviada");
            } else {
                $this->_helper->flashMessenger->addMessage('Tu ya has solicitado el ingreso a esta comunidad');
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function leaveAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $model_communities = new Communities();

        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);

        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        $model_communities_users = new Communities_Users();
        $assignement = $model_communities_users->findByCommunityAndUser($community->ident, $this->user->ident);

        if ($assignement <> NULL) {
            $assignement->delete();
            $community->members = $community->members - 1;
            $community->save();
            
            $this->_helper->flashMessenger->addMessage("Tu has dejado la communidad {$community->label}");
        } else {
            $this->_helper->flashMessenger->addMessage('Tu no perteneces a&uacute;n a esa comunidad');
        }

        $this->_redirect($this->view->currentPage());
    }
}
