<?php

class Teams_ManagerController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('subjects', 'teach')) {
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

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_teams = new Teams();
        $list_teams = $model_teams->selectAll($group->ident);

        $this->view->model_teams = $model_teams;
        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->teams = $list_teams;

        $this->history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/manager');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->team = new Teams_Empty();

        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();
            $session = new Zend_Session_Namespace('yachay');

            $model_teams = new Teams();
            $team = $model_teams->createRow();
            $team->label = $request->getParam('label');
            $team->url = $convert->convert($team->label);
            $team->description = $request->getParam('description');
            $team->group = $group->ident;

            if ($team->isValid()) {
                $team->author = $USER->ident;
                $team->tsregister = time();
                $team->save();

                $this->_helper->flashMessenger->addMessage("El equipo {$team->label} se ha creado correctamente");
                $session->url = $team->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($team->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }

            $this->view->team = $team;
        }

        $this->history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/new');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        if ($request->isPost()) {
            $model_teams = new Teams();
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $model_teams->findByIdent($value);
                $team->status = 'inactive';
                $team->save();
            }
            $count = count($check);

            $this->_helper->flashMessenger->addMessage("Se han desactivado $count equipos");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        if ($request->isPost()) {
            $model_teams = new Teams();
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $model_teams->findByIdent($value);
                $team->status = 'active';
                $team->save();
            }
            $count = count($check);

            $this->_helper->flashMessenger->addMessage("Se han activado $count equipos");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        if ($request->isPost()) {
            $model_teams = new Teams();
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $team = $model_teams->findByIdent($value);
                $team->delete();
            }
            $count = count($check);

            $this->_helper->flashMessenger->addMessage("Se han eliminado $count equipos");
        }
        $this->_redirect($this->view->currentPage());
    }
}
