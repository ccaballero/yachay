<?php

class Groups_GroupController extends Yeah_Action
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

        context('group', $group);

        $teams = Yeah_Adapter::getModel('teams');
        $listteams = $teams->selectByStatus($group->ident, 'active');

        $resources = $group->findmodules_resources_models_ResourcesViamodules_groups_models_Groups_Resources($group->select()->order('tsregister DESC'));

        // PAGINATOR
        $request = $this->getRequest();
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->teams = $listteams;
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
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
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

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);

        context('group', $group);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $group->label = $request->getParam('label');
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
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            $breadcrumb[$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
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

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);

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
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);

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
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);

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
