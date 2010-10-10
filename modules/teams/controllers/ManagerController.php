<?php

class Teams_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('subjects', 'teach')) {
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
        }

        $gestions_model = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions_model->findByActive();

        $subjects_model = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects_model->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups_model = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups_model->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $teams_model = Yeah_Adapter::getModel('teams');
        $teamlist = $teams_model->selectAll($group->ident);

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->model = $teams_model;
        $this->view->teams = $teamlist;

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/manager');
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
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

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
        $this->requireTeacher($group);

        $this->view->group = $group;
        $this->view->team = new modules_teams_models_Teams_Empty;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $teams = Yeah_Adapter::getModel('teams');
            $team = $teams->createRow();
            $team->label = $request->getParam('label');
            $team->url = convert($team->label);
            $team->description = $request->getParam('description');
            $team->group = $group->ident;

            if ($team->isValid()) {
                $team->author = $USER->ident;
                $team->tsregister = time();
                $team->save();

                $session->messages->addMessage("El equipo {$team->label} se ha creado correctamente");
                $session->url = $team->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($team->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->team = $team;
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/new');
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

        if ($request->isPost()) {
            $teams = Yeah_Adapter::getModel('teams');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $teams->findByIdent($value);
                $team->status = 'inactive';
                $team->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han desactivado $count equipos");
        }
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

        if ($request->isPost()) {
            $teams = Yeah_Adapter::getModel('teams');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $teams->findByIdent($value);
                $team->status = 'active';
                $team->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han activado $count equipos");
        }
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

        if ($request->isPost()) {
            $teams = Yeah_Adapter::getModel('teams');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $teams->findByIdent($value);
                $team->delete();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count equipos");
        }
        $this->_redirect($this->view->currentPage());
    }
}
