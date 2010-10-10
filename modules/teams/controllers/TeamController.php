<?php

class Teams_TeamController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);
        $this->requireMemberTeam($team);

        context('team', $team);

        $members = $team->findmodules_users_models_UsersViamodules_teams_models_Teams_Users();
        $resources = $team->findmodules_resources_models_ResourcesViamodules_teams_models_Teams_Resources($team->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->team = $team;
        $this->view->members = $members;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'teams_team_view',
            'params' => array (
            	'subject' => $subject->url,
                'group' => $group->url,
                'team' => $team->url,
            ),
        );

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/' . $team->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);
        $this->requireMemberTeam($team);

        context('team', $team);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $team->label = $request->getParam('label');
            $team->url = convert($team->label);
            $team->description = $request->getParam('description');

            if ($team->isValid()) {
                $team->save();

                $session->messages->addMessage("El equipo {$team->label} se ha actualizado correctamente");
                $session->url = $team->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($team->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->team = $team;
        
        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/' . $team->url . '/edit');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
            $breadcrumb[$team->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url, 'team' => $team->url), 'teams_team_view');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);

        $team->status = 'inactive';
        $team->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$team->label} ha sido desactivado");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);

        $team->status = 'active';
        $team->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$team->label} ha sido activado");

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);

        $label = $team->label;
        $team->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$label} ha sido eliminado");

        $this->_redirect($this->view->currentPage());
    }
}
