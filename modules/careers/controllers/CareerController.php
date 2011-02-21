<?php

class Careers_CareerController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('careers', 'view');
        $request = $this->getRequest();

        $model_careers = new Careers();
        $career = $model_careers->findByUrl($request->getParam('career'));
        $this->requireExistence($career, 'career', 'careers_career_view', 'careers_list');

        context('career', $career);

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects_users = new Subjects_Users();
        $subjects1 = $career->findSubjectsViaCareers_Subjects();
        $subjects2 = array();
        foreach ($subjects1 as $subject) {
            if ($subject->gestion == $gestion->ident) {
                if ($subject->status == 'active' || $this->acl('subjects', 'lock')) {
                    switch ($subject->visibility) {
                        case 'public':
                            $subjects2[] = $subject;
                            break;
                        case 'register':
                            if ($USER->role != 1) {
                                $subjects2[] = $subject;
                            }
                            break;
                        case 'private':
                            if ($USER->role != 1) {
                                if ($this->acl('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                } else {
                                    $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $USER->ident);
                                    if (!empty($assign)) {
                                        $subjects2[] = $subject;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }

        $resources = $career->findResourcesViaCareers_Resources($career->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'careers_career_view',
            'params' => array (
                'career' => $career->url,
            ),
        );

        $this->view->model_careers = $model_careers;
        $this->view->career = $career;
        $this->view->subjects = $subjects2;

        history('careers/' . $career->url);
        $breadcrumb = array();
        if ($this->acl('careers', 'list')) {
            $breadcrumb['Carreras'] = $this->view->url(array(), 'careers_list');
        }
        if ($this->acl('careers', array('new', 'delete'))) {
            $breadcrumb['Administrador de carreras'] = $this->view->url(array(), 'careers_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('careers', 'edit');

        $request = $this->getRequest();
        $model_careers = new Careers();
        $career = $model_careers->findByUrl($request->getParam('career'));
        $this->requireExistence($career, 'career', 'careers_career_view', 'careers_list');

        context('career', $career);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $career->label = $request->getParam('label');
            $career->url = convert($career->label);
            $career->description = $request->getParam('description');

            if ($career->isValid()) {
                $career->save();

                $session->messages->addMessage("La carrera {$career->label} se ha actualizado correctamente");
                $session->url = $career->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($career->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model_careers = $model_careers;
        $this->view->career = $career;

        history('careers/' . $career->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('careers', 'list')) {
            $breadcrumb['Carreras'] = $this->view->url(array(), 'careers_list');
        }
        if ($this->acl('careers', array('new', 'delete'))) {
            $breadcrumb['Administrador de carreras'] = $this->view->url(array(), 'careers_manager');
        }
        if ($this->acl('careers', 'view')) {
            $breadcrumb[$career->label] = $this->view->url(array('career' => $career->url), 'careers_career_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('careers', 'delete');
        $request = $this->getRequest();
        $url = $request->getParam('career');

        $model_careers = new Careers();
        $career = $model_careers->findByUrl($url);

        $session = new Zend_Session_Namespace();
        if (!empty($career) && $career->isEmpty()) {
            $label = $career->label;
            $career->delete();
            $session->messages->addMessage("La carrera $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La carrera no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
