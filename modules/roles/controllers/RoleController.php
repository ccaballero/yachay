<?php

class Roles_RoleController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('roles', 'view');

        $request = $this->getRequest();
        $roles = Yeah_Adapter::getModel('roles');
        $role = $roles->findByUrl($request->getParam('role'));

        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        $this->view->model = $roles;
        $this->view->role = $role;

        history('roles/' . $role->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_manager');
        } else if (Yeah_Acl::hasPermission('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        global $USER;

        $this->requirePermission('roles', 'edit');

        $request = $this->getRequest();
        $roles = Yeah_Adapter::getModel('roles');
        $role = $roles->findByUrl($request->getParam('role'));

        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        $privileges = Yeah_Adapter::getModel('privileges');
        $this->view->privileges = $privileges->selectAll();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $roles_privileges = Yeah_Adapter::getModel('roles', 'Roles_Privileges');

            $role->label = $request->getParam('label');
            $role->description = $request->getParam('description');
            $privileges_idents = $request->getParam('privileges');

            if ($role->isValid()) {
                $role->save();
                // delete of privileges in role
                $roles_privileges->deletePrivilegesInRole($role->ident);
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
                $session->messages->addMessage("El rol {$role->label} se ha actualizado correctamente");
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

        $this->view->model = $roles;
        $this->view->role = $role;

        $roles_privileges = $role->findManyToManyRowset('modules_privileges_models_Privileges', 'modules_roles_models_Roles_Privileges');
        $idents_privileges = array();
        foreach ($roles_privileges as $rol_privilege) {
            $idents_privileges[] = $rol_privilege->ident;
        }
        $this->view->role_privilege = $idents_privileges;

        history('roles/' . $role->url . '/edit');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_manager');
        } else if (Yeah_Acl::hasPermission('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        if (Yeah_Acl::hasPermission('roles', 'view')) {
            $breadcrumb[$role->label] = $this->view->url(array('role' => $role->url), 'roles_role_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('roles', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('role');
        $roles = Yeah_Adapter::getModel('roles');
        $role = $roles->findByUrl($url);

        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        $session = new Zend_Session_Namespace();
        if (!empty($role) && $role->isEmpty()) {
            $label = $role->label;
            $role->delete();
            $session->messages->addMessage("El rol $label ha sido eliminado");
        } else {
            $session->messages->addMessage("El rol no puede ser eliminado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
