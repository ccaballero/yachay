<?php

class Roles_ManagerController extends Yachay_Controller_Action {

    public function indexAction() {
        $this->requirePermission('roles', 'list');
        $this->requirePermission('roles', array('new', 'assign', 'delete'));

        $model_roles = new Roles();

        $this->view->model_roles = $model_roles;
        $this->view->roles = $model_roles->selectAll();

        $this->history('roles/manager');
        $breadcrumb = array();
        if ($this->acl('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('roles', 'new');

        $model_privileges = new Privileges();

        $this->view->role = new Roles_Empty();
        $this->view->role_privilege = array();
        $this->view->privileges = $model_privileges->selectAll();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();
            $session = new Zend_Session_Namespace('yachay');

            $model_roles = new Roles();
            $model_roles_privileges = new Roles_Privileges();

            $role = $model_roles->createRow();
            $role->label = $request->getParam('label');
            $role->url = $convert->convert($role->label);

            $role->description = $request->getParam('description');
            $privileges_idents = $request->getParam('privileges');

            if ($role->isValid()) {
                $role->tsregister = time();
                $role->save();

                // privileges register
                foreach ($privileges_idents as $privilege_ident) {
                    $privilege_ident = intval($privilege_ident);
                    if (is_int($privilege_ident)) {
                        $role_privilege = $model_roles_privileges->createRow();
                        $role_privilege->role = $role->ident;
                        $role_privilege->privilege = $privilege_ident;
                        $role_privilege->save();
                    }
                }

                $this->_helper->flashMessenger->addMessage("El rol {$role->label} se ha creado correctamente");

                $session->url = $role->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($role->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }

            $this->view->role = $role;
            $this->view->role_privilege = $privileges_idents;
        }

        $this->history('roles/new');
        $breadcrumb = array();
        if ($this->acl('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        if ($this->acl('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Administrador de roles'] = $this->view->url(array(), 'roles_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
