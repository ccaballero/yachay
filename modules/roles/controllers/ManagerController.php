<?php

class Roles_ManagerController extends Yeah_Action {

    public function indexAction() {
        $this->requirePermission('roles', 'list');
        $this->requirePermission('roles', array('new', 'assign', 'delete'));

        $roles = Yeah_Adapter::getModel('roles');
        $this->view->model = $roles;
        $this->view->roles = $roles->selectAll();

        history('roles/manager');
        breadcrumb();
    }

    public function newAction() {
        $this->requirePermission('roles', 'new');

        $this->view->role = new modules_roles_models_Roles_Empty;
        $this->view->role_privilege = array();

        $privileges = Yeah_Adapter::getModel('privileges');
        $this->view->privileges = $privileges->selectAll();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $roles = Yeah_Adapter::getModel('roles');
            $roles_privileges = Yeah_Adapter::getModel('roles', 'Roles_Privileges');

            $role = $roles->createRow();
            $role->label = $request->getParam('label');
            $role->description = $request->getParam('description');
            $privileges_idents = $request->getParam('privileges');

            if ($role->isValid()) {
                $role->tsregister = time();
                $role->save();
                // privileges register
                foreach ($privileges_idents as $privilege_ident) {
                    $privilege_ident = intval($privilege_ident);
                    if (is_int($privilege_ident)) {
                        $role_privilege = $roles_privileges->createRow();
                        $role_privilege->role = $role->ident;
                        $role_privilege->privilege = $privilege_ident;
                        $role_privilege->save();
                    }
                }
                $session->messages->addMessage("El rol {$role->label} se ha creado correctamente");
                $session->url = $role->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($role->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->role = $role;
            $this->view->role_privilege = $privileges_idents;
        }

        history('roles/new');
        $breadcrumb = array();
        $breadcrumb['Roles'] = $this->view->url(array(), 'roles_manager');
        breadcrumb($breadcrumb);
    }
}
