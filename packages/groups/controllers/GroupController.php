<?php

class Groups_GroupController extends Yachay_Controller_Action
{
    public function viewAction() {
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

        $this->context('group', $group);

        $model_teams = new Teams();
        $list_teams = $model_teams->selectByStatus($group->ident, 'active');

        $resources = $group->findResourcesViaGroups_Resources($group->select()->order('tsregister DESC'));

        // PAGINATOR
        $request = $this->getRequest();
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->teams = $list_teams;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'groups_group_view',
            'params' => array (
                'subject' => $subject->url,
                'group' => $group->url,
            ),
        );

        $this->history('subjects/' . $subject->url . '/groups/' . $group->url);
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
        }
        $this->breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);

        $this->context('group', $group);

        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();
            $session = new Zend_Session_Namespace('yachay');

            $group->label = $request->getParam('label');
            $group->url = $convert->convert($group->label);
            $group->teacher = $request->getParam('teacher');
            $group->evaluation = $request->getParam('evaluation');
            $group->description = $request->getParam('description');

            if ($group->isValid()) {
                $group->save();

                $this->_helper->flashMessenger->addMessage("El grupo {$group->label} se ha actualizado correctamente");

                $session->url = $group->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($group->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        } else {
            $this->history('subjects/' . $subject->url . '/groups/' . $group->url . '/edit');
        }

        $this->view->subject = $subject;
        $this->view->group = $group;

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
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function calificationAction() {
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

        $evaluation = $group->getEvaluation();
        $tests = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));

        $model_califications = new Califications();
        foreach ($tests as $test) {
            if (!empty($test->formula)) {
                $califications[$test->ident] = $model_califications->getCalification($group->ident, $this->user->ident, $evaluation->ident, $test);
            } else {
                $_calification = $model_califications->findCalification($group->ident, $this->user->ident, $evaluation->ident, $test->ident);
                if (empty($_calification)) {
                    $califications[$test->ident] = '--';
                } else {
                    $califications[$test->ident] = $_calification->calification;
                }
            }
        }

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->model = $model_califications;
        $this->view->test_evaluations = $tests;
        $this->view->califications = $califications;

        $this->history('subjects/' . $subject->url . '/groups/' . $group->url . '/calification');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);

        $group->status = 'inactive';
        $group->save();

        $this->_helper->flashMessenger->addMessage("El grupo {$group->label} ha sido desactivado");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);

        $group->status = 'active';
        $group->save();

        $this->_helper->flashMessenger->addMessage("El grupo {$group->label} ha sido activado");

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);

        if ($group->isEmpty()) {
            $group->delete();
            $this->_helper->flashMessenger->addMessage("El grupo {$group->label} ha sido desactivado");
        } else {
            $this->_helper->flashMessenger->addMessage("El grupo {$group->label} no puede ser eliminado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
