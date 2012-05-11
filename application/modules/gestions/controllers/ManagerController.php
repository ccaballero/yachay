<?php

class Gestions_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('gestions', 'list');
        $this->requirePermission('gestions', array('new', 'active', 'delete'));

        $model_gestions = new Gestions();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('gestions', 'active')) {
                $gestion_ident = $request->getParam('radio');
                $gestion = $model_gestions->findByIdent($gestion_ident);
                if ($gestion->status == 'inactive') {
                    // clear all gestions
                    $model_gestions->desactiveAll();
                    // Active the selected gestion
                    $gestion->status = 'active';
                    $gestion->save();
                }

                $this->_helper->flashMessenger->addMessage("La gestion {$gestion->label} ha sido establecida como actual");
            }
        } else {
            $this->history('gestions/manager');
        }

        $this->view->model_gestions = $model_gestions;
        $this->view->gestions = $model_gestions->selectAll();

        $breadcrumb = array();
        if ($this->acl('gestions', 'list')) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('gestions', 'new');

        $this->view->gestion = new Gestions_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();
            $session = new Zend_Session_Namespace('yachay');

            $model_gestions = new Gestions();
            $gestion = $model_gestions->createRow();
            $gestion->label = $request->getParam('label');
            $gestion->url = $convert->convert($gestion->label);

            if ($gestion->isValid()) {
                $gestion->tsregister = time();
                $gestion->save();

                $this->_helper->flashMessenger->addMessage("La gestion {$gestion->label} se ha creado correctamente");

                $session->url = $gestion->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($gestion->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
            
            $this->view->gestion = $gestion;
        } else {
            $this->history('gestions/new');
        }

        $breadcrumb = array();
        if ($this->acl('gestions', 'list')) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
        }
        if ($this->acl('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Administrador de gestiones'] = $this->view->url(array(), 'gestions_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
