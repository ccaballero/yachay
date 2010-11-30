<?php

class Groups_GroupController extends Yeah_Action
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

        context('group', $group);

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

        history('subjects/' . $subject->url . '/groups/' . $group->url);
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
        breadcrumb($breadcrumb);
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

        context('group', $group);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $group->label = $request->getParam('label');
            $group->url = convert($group->label);
            $group->teacher = $request->getParam('teacher');
            $group->evaluation = $request->getParam('evaluation');
            $group->description = $request->getParam('description');

            if ($group->isValid()) {
                $group->save();

                $session->messages->addMessage("El grupo {$group->label} se ha actualizado correctamente");
                $session->url = $group->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($group->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->subject = $subject;
        $this->view->group = $group;

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/edit');
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
        breadcrumb($breadcrumb);
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

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El grupo {$group->label} ha sido desactivado");

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

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El grupo {$group->label} ha sido activado");

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

        $session = new Zend_Session_Namespace();
        if ($group->isEmpty()) {
            $group->delete();
            $session->messages->addMessage("El grupo {$group->label} ha sido desactivado");
        } else {
            $session->messages->addMessage("El grupo {$group->label} no puede ser eliminado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
