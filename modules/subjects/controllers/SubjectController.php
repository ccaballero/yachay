<?php

class Subjects_SubjectController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('subjects', 'view');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $areas = Yeah_Adapter::getModel('areas');
        $subjects = Yeah_Adapter::getModel('subjects');
        $groups = Yeah_Adapter::getModel('groups');

        $urlgestion = $request->getParam('gestion');
        $urlsubject = $request->getParam('subject');
        if (empty($urlgestion)) {
            $gestion = $gestions->findByActive();
            $historial = false;
        } else {
            $historial = true;
            $gestion = $gestions->findByUrl($urlgestion);
        }

        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        context('subject', $subject);

        $url = $this->view->url(array(), 'subjects_list');
        if ($subject->status == 'inactive' && !Yeah_Acl::hasPermission('subjects', 'edit')) {
            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("La materia {$subject->label} no esta activa");
            $this->_redirect($url);
        }

        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        switch ($subject->visibility) {
            case 'public':
                break;
            case 'register':
                if ($USER->role == 1) {
                    $this->_redirect($url);
                }
                break;
            case 'private':
                if ($USER->role == 1) {
                    $this->_redirect($url);
                    return;
                }
                if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                    break;
                }
                if ($subject->moderator == $USER->ident) {
                    break;
                }
                $assign = $assignement->findBySubjectAndUser($subject->ident, $USER->ident);
                if (empty($assign)) {
                    $this->_redirect($url);
                }
                break;
        }

        $listareas = $subject->findmodules_areas_models_AreasViamodules_areas_models_Areas_Subjects();
        $listgroups = $groups->selectByStatus($subject->ident, 'active');

        $resources = $subject->findmodules_resources_models_ResourcesViamodules_subjects_models_Subjects_Resources($subject->select()->order('tsregister DESC'));

        // PAGINATOR
        $request = $this->getRequest();
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model = $subjects;
        $this->view->historial = $historial;
        $this->view->gestion = $gestion->url;
        $this->view->areas = $listareas;
        $this->view->subject = $subject;
        $this->view->groups = $listgroups;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'subjects_subject_view',
            'params' => array (
                'subject' => $subject->url,
            ),
        );

        if ($historial) {
            history('gestions/' . $gestion->url . '/' . $subject->url);
            $breadcrumb = array();
            if (Yeah_Acl::hasPermission('gestions', array('new', 'active', 'delete'))) {
                $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_manager');
            } else if (Yeah_Acl::hasPermission('gestions', 'list')) {
                $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
            }
            if (Yeah_Acl::hasPermission('gestions', 'view')) {
                $breadcrumb[$gestion->label] = $this->view->url(array('gestion' => $gestion->url), 'gestions_gestion_view');
            }
            breadcrumb($breadcrumb);
        } else {
            history('subjects/' . $subject->url);
            $breadcrumb = array();
            if (Yeah_Acl::hasPermission('gestions', array('new', 'import', 'export', 'lock', 'delete'))) {
                $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
            } else if (Yeah_Acl::hasPermission('areas', 'list')) {
                $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
            }
            breadcrumb($breadcrumb);
        }
    }

    public function editAction() {
        $this->requirePermission('subjects', 'edit');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();
        $areas = Yeah_Adapter::getModel('areas');
        $subjects = Yeah_Adapter::getModel('subjects');
        $subject = $subjects->findByUrl($gestion->ident, $request->getParam('subject'));
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        context('subject', $subject);

        $checks = array();
        $listareas = $subject->findManyToManyRowset('modules_areas_models_Areas', 'modules_areas_models_Areas_Subjects');
        foreach ($listareas as $area) {
            $checks[] = $area->ident;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $subject->label = $request->getParam('label');
            $subject->moderator = $request->getParam('moderator');
            $subject->code = $request->getParam('code');
            $subject->visibility = $request->getParam('visibility');
            $subject->description = $request->getParam('description');

            $checks = $request->getParam('areas');
            if (empty($checks)) {
                $checks = array();
            }

            if ($subject->isValid()) {
                $subject->save();

                // FIXME Llevar a modelo las modificaciones de base de datos
                global $DB;
                $DB->delete('area_subject', 'subject = ' . $subject->ident);
                $assignement = Yeah_Adapter::getModel('areas', 'Areas_Subjects');
                foreach ($checks as $area) {
                    $assign = $assignement->createRow();
                    $assign->area = $area;
                    $assign->subject = $subject->ident;
                    $assign->save();
                }

                $session->messages->addMessage("La materia {$subject->label} se ha actualizado correctamente");
                $session->url = $subject->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($subject->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model = $subjects;
        $this->view->areas = $areas->selectAll();
        $this->view->checks = $checks;
        $this->view->subject = $subject;

        history('subjects/' . $subject->url . '/edit');
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

    public function lockAction() {
        $this->requirePermission('subjects', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('subject');
        $subjects = Yeah_Adapter::getModel('subjects');
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();
        $subject = $subjects->findByUrl($gestion->ident, $url);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $session = new Zend_Session_Namespace();
        $label = utf8_decode($subject->label);

        $subject->status = 'inactive';
        $subject->save();
        $session->messages->addMessage("La materia $label ha sido desactivada");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('subject');
        $subjects = Yeah_Adapter::getModel('subjects');
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();
        $subject = $subjects->findByUrl($gestion->ident, $url);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $session = new Zend_Session_Namespace();
        $label = utf8_decode($subject->label);

        $subject->status = 'active';
        $subject->save();
        $session->messages->addMessage("La materia $label ha sido activada");

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('subject');
        $subjects = Yeah_Adapter::getModel('subjects');
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();
        $subject = $subjects->findByUrl($gestion->ident, $url);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $session = new Zend_Session_Namespace();
        $label = utf8_decode($subject->label);
        if ($subject->isEmpty()) {
            $subject->delete();
            $session->messages->addMessage("La materia $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La materia $label no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
