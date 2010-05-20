<?php

class Groups_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
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

        $groups = Yeah_Adapter::getModel('groups');
        $this->view->model = $groups;
        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->groups = $groups->selectAll($subject->ident);

        history('subjects/' . $subject->url . '/groups/manager');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $this->view->subject = $subject;
        $this->view->group = new modules_groups_models_Groups_Empty;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $groups = Yeah_Adapter::getModel('groups');
            $group = $groups->createRow();
            $group->label = $request->getParam('label');
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
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $groups = Yeah_Adapter::getModel('groups');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $group = $groups->findByIdent($value);
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
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $groups = Yeah_Adapter::getModel('groups');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $group = $groups->findByIdent($value);
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
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        if ($request->isPost()) {
            $groups = Yeah_Adapter::getModel('groups');
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $group = $groups->findByIdent($value);
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
