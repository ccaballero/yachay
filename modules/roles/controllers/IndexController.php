<?php

class Roles_IndexController extends Yeah_Action {

    public function indexAction() {
        $this->requirePermission('roles', 'list');

        $roles = Yeah_Adapter::getModel('roles');

        $this->view->model = $roles;
        $this->view->roles = $roles->selectAll();

        history('roles');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
            $breadcrumb['Roles'] = $this->view->url(array(), 'roles_manager');
        }
        breadcrumb($breadcrumb);
    }
}
