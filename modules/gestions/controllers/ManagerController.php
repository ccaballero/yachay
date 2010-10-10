<?php

class Gestions_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('gestions', 'list');
        $this->requirePermission('gestions', array('new', 'active', 'delete'));

        $gestions = Yeah_Adapter::getModel('gestions');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('gestions', 'active')) {
                $gestion_ident = $request->getParam('radio');
                $gestion = $gestions->findByIdent($gestion_ident);
                if ($gestion->status == 'inactive') {
                    // clear all gestions
                    $gestions->desactiveAll();
                    // Active the selected gestion
                    $gestion->status = 'active';
                    $gestion->save();
                }
                $session = new Zend_Session_Namespace();
                $session->messages->addMessage("La gestion {$gestion->label} ha sido establecida como actual");
            }
        }

        $this->view->model = $gestions;
        $this->view->gestions = $gestions->selectAll();

        history('gestions/manager');
        breadcrumb();
    }

    public function newAction() {
        $this->requirePermission('gestions', 'new');

        $this->view->gestion = new modules_gestions_models_Gestions_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->createRow();
            $gestion->label = $request->getParam('label');
            $gestion->url = convert($gestion->label);

            if ($gestion->isValid()) {
                $gestion->tsregister = time();
                $gestion->save();
                $session->url = $gestion->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($gestion->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
            
            $this->view->gestion = $gestion;
        }

        history('gestions/new');
        $breadcrumb = array();
        $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_manager');
        breadcrumb($breadcrumb);
    }
}
