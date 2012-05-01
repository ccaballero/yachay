<?php

class Roles_RoleController extends Yachay_Action
{
    public function viewAction() {
        $this->requirePermission('roles', 'view');

        $request = $this->getRequest();
        $model_roles = new Roles();
        $role = $model_roles->findByUrl($request->getParam('role'));

        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        $model_users = new Users();
        $users = $model_users->selectByRole($role->ident);

        $model_privileges = new Privileges();
        $privileges = $role->findPrivilegesViaRoles_Privileges($role->select()->order('module ASC')->order('privilege ASC'));

        $this->view->model_roles = $model_roles;
        $this->view->role = $role;
        $this->view->model_users = $model_users;
        $this->view->users = $users;
        $this->view->model_privileges = $model_privileges;
        $this->view->privileges = $privileges;

        $this->history('roles/' . $role->url);
        $breadcrumb = array();
        if ($this->acl('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        if ($this->acl('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Administrador de roles'] = $this->view->url(array(), 'roles_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('roles', 'edit');

        $request = $this->getRequest();
        $model_roles = new Roles();

        $role = $model_roles->findByUrl($request->getParam('role'));
        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        $model_privileges = new Privileges();
        $this->view->privileges = $model_privileges->selectAll();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $model_roles_privileges = new Roles_Privileges();

            $role->label = $request->getParam('label');
            $role->url = convert($role->label);
            $role->description = $request->getParam('description');
            $privileges_idents = $request->getParam('privileges');

            if ($role->isValid()) {
                $role->save();
                // delete of privileges in role
                $model_roles_privileges->deletePrivilegesInRole($role->ident);
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
                
                $this->_helper->flashMessenger->addMessage("El rol {$role->label} se ha actualizado correctamente");
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

        $this->view->model_roles = $model_roles;
        $this->view->role = $role;

        $roles_privileges = $role->findPrivilegesViaRoles_Privileges();
        $idents_privileges = array();
        foreach ($roles_privileges as $rol_privilege) {
            $idents_privileges[] = $rol_privilege->ident;
        }
        $this->view->role_privilege = $idents_privileges;

        $this->history('roles/' . $role->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        if ($this->acl('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Administrador de roles'] = $this->view->url(array(), 'roles_manager');
        }
        if ($this->acl('roles', 'view')) {
            $breadcrumb[$role->label] = $this->view->url(array('role' => $role->url), 'roles_role_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('roles', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('role');
        $model_roles = new Roles();

        $role = $model_roles->findByUrl($url);
        $this->requireExistence($role, 'role', 'roles_role_view', 'roles_list');

        if (!empty($role) && $role->isEmpty()) {
            $label = $role->label;
            $role->delete();
            $this->_helper->flashMessenger->addMessage("El rol $label ha sido eliminado");
        } else {
            $this->_helper->flashMessenger->addMessage('El rol no puede ser eliminado');
        }

        $this->_redirect($this->view->currentPage());
    }
}
