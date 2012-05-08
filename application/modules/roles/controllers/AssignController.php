<?php

class Roles_AssignController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('roles', 'assign');

        $model_users = new Users();
        $model_roles = new Roles();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $radio = $request->getParam('radio');
            foreach ($radio as $user_ident => $role_ident) {
                $role_ident = intval($role_ident);
                if (is_int($role_ident)) {
                    $user = $model_users->findByIdent($user_ident);
                    if ($this->user->ident != $user->ident) {
                        $user->role = $role_ident;
                        $user->save();
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage('La asignación de roles ha sido actualizada correctamente');
        }

        $users = $model_users->selectAll();
        $roles = $model_roles->selectAll();

        $this->view->model_users = $model_users;
        $this->view->users = $users;
        $this->view->model_roles = $model_roles;
        $this->view->roles = $roles;

        $this->history('roles/assign');
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
