<?php

class Roles_AssignController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('roles', 'assign');

        $model_users = new Users();
        $model_roles = new Roles();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $radio = $request->getParam('radio');
            foreach ($radio as $user_ident => $role_ident) {
                $role_ident = intval($role_ident);
                if (is_int($role_ident)) {
                    $user = $model_users->findByIdent($user_ident);
                    if ($USER->ident != $user->ident) {
                        $user->role = $role_ident;
                        $user->save();
                    }
                }
            }
            $session->messages->addMessage("La asignación de roles ha sido actualizada correctamente");
        }

        $users = $model_users->selectAll();
        $roles = $model_roles->selectAll();

        $this->view->model_users = $model_users;
        $this->view->users = $users;
        $this->view->model_roles = $model_roles;
        $this->view->roles = $roles;

        history('roles/assign');
        $breadcrumb = array();
        if ($this->acl('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        if ($this->acl('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Administrador de roles'] = $this->view->url(array(), 'roles_manager');
        }
        breadcrumb($breadcrumb);
    }
}
