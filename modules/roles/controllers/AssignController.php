<?php

class Roles_AssignController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('roles', 'assign');

        $users_model = Yeah_Adapter::getModel('users');
        $roles_model = Yeah_Adapter::getModel('roles');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $radio = $request->getParam('radio');
            foreach ($radio as $user_ident => $role_ident) {
                $role_ident = intval($role_ident);
                if (is_int($role_ident)) {
                    $user = $users_model->findByIdent($user_ident);
                    if ($USER->ident != $user->ident) {
                        $user->role = $role_ident;
                        $user->save();
                    }
                }
            }
            $session->messages->addMessage("La asignacion de roles ha sido actualizada correctamente");
        }

        $users = $users_model->selectAll();
        $roles = $roles_model->selectAll();

        $this->view->users = $users;
        $this->view->roles = $roles;

        history('roles/assign');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_manager');
        } else if (Yeah_Acl::hasPermission('roles', 'list')) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_list');
        }
        breadcrumb($breadcrumb);
    }
}
