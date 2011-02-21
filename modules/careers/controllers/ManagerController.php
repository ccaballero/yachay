<?php

class Careers_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('careers', 'list');
        $this->requirePermission('careers', array('new', 'delete'));

        $model_careers = new Careers();

        $this->view->model_careers = $model_careers;
        $this->view->careers = $model_careers->selectAll();

        history('careers/manager');
        $breadcrumb = array();
        if ($this->acl('careers', 'list')) {
            $breadcrumb['Carreras'] = $this->view->url(array(), 'careers_list');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('careers', 'new');

        $this->view->career = new Careers_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_careers = new Careers();
            $career = $model_careers->createRow();
            $career->label = $request->getParam('label');
            $career->url = convert($career->label);
            $career->description = $request->getParam('description');

            if ($career->isValid()) {
                $career->tsregister = time();
                $career->save();
                $session->messages->addMessage("La carrera {$career->label} se ha creado correctamente");
                $session->url = $career->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($career->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->career = $career;
        }

        history('careers/new');
        $breadcrumb = array();
        if ($this->acl('careers', 'list')) {
            $breadcrumb['Carreras'] = $this->view->url(array(), 'careers_list');
        }
        if ($this->acl('careers', array('new', 'delete'))) {
            $breadcrumb['Administrador de carreras'] = $this->view->url(array(), 'careers_manager');
        }
        breadcrumb($breadcrumb);
    }
}
