<?php

class Groups_ManagerController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $url_subject = $request->getParam('subject');
        $model_subjects = new Subjects();
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
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

        $model_groups = new Groups();

        $this->view->model_groups = $model_groups;
        $this->view->gestion = $active_gestion;
        $this->view->subject = $subject;
        $this->view->groups = $model_groups->selectAll($subject->ident);

        history('subjects/' . $subject->url . '/groups/manager');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $this->view->subject = $subject;
        $this->view->group = new Groups_Empty();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_groups = new Groups();
            $group = $model_groups->createRow();
            $group->label = $request->getParam('label');
            $group->url = convert($group->label);
            $group->teacher = $request->getParam('teacher');
            $group->evaluation = $request->getParam('evaluation');
            $group->description = $request->getParam('description');

            $group->subject = $subject->ident;

            if ($group->isValid()) {
                $group->author = $USER->ident;
                $group->tsregister = time();
                $group->save();

                $session->messages->addMessage("El grupo {$group->label} se ha creado correctamente");
                $session->url = $group->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($group->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->group = $group;
        }

        history('subjects/' . $subject->url . '/groups/new');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $model_groups = new Groups();
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $group = $model_groups->findByIdent($value);
                $group->status = 'inactive';
                $group->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han desactivado $count grupos");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $model_groups = new Groups();
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $group = $model_groups->findByIdent($value);
                $group->status = 'active';
                $group->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han activado $count grupos");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $model_groups = new Groups();
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $group = $model_groups->findByIdent($value);
                if ($group->isEmpty()) {
                    $group->delete();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count grupos");
        }
        $this->_redirect($this->view->currentPage());
    }
}
