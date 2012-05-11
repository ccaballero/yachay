<?php

class Communities_PetitionController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $model_communities = new Communities();

        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);
        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        if ($request->isPost()) {
            if ($community->amModerator()) {
                $accept = $request->getParam('accept');
                $decline = $request->getParam('decline');
                if (!empty($accept)) {
                    $this->_forward('accept');
                } else if (!empty($decline)) {
                    $this->_forward('decline');
                }
            }
        } else {
            $this->history('communities/' . $community->url . '/petition');
        }

        $this->context('community', $community);

        $applicants = $community->findUsersViaCommunities_Petitions($community->select()->order('tsregister ASC'));

        $this->view->model_communities = $model_communities;
        $this->view->community = $community;
        $this->view->applicants = $applicants;

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

    public function acceptAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_users = new Communities_Users();
            $model_communities_petitions = new Communities_Petitions();

            $applicants = $request->getParam("applicants");
            $count = 0;

            foreach ($applicants as $applicant) {
                $user = $model_users->findByIdent($applicant);
                if (!empty($user)) {
                    $row = $model_communities_users->createRow();
                    $row->community = $community->ident;
                    $row->user = $user->ident;
                    $row->type = 'member';
                    $row->status = 'active';
                    $row->tsregister = time();
                    $row->save();

                    $row = $model_communities_petitions->findByCommunityAndUser($community->ident, $user->ident);
                    $row->delete();
                    $count++;
                }
            }

            $community->members = $community->members + $count;
            $community->petitions = $community->petitions - $count;
            $community->save();

            $this->_helper->flashMessenger->addMessage("Se han aceptado a $count miembros en la comunidad");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function declineAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $model_communities = new Communities();

            $url = $request->getParam('community');
            $community = $model_communities->findByUrl($url);
            $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');
            $this->requireCommunityModerator($community);

            $model_users = new Users();
            $model_communities_petitions = new Communities_Petitions();

            $applicants = $request->getParam("applicants");
            $count = 0;

            foreach ($applicants as $applicant) {
                $user = $model_users->findByIdent($applicant);
                if (!empty($user)) {
                    $row = $model_communities_petitions->findByCommunityAndUser($community->ident, $user->ident);
                    $row->delete();
                    $count++;
                }
            }

            $community->petitions = $community->petitions - $count;
            $community->save();

            $this->_helper->flashMessenger->addMessage("Se han rechazado a $count miembros de la comunidad");
        }

        $this->_redirect($this->view->currentPage());
    }
}
