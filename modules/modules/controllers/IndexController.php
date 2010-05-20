<?php

class Modules_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('modules', 'list');

        $modules = Yeah_Adapter::getModel('modules');

        $this->view->model = $modules;
        $this->view->modules = $modules->selectAll();

        history('modules');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('modules', array('new', 'lock'))) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_manager');
        }
        breadcrumb($breadcrumb);
    }
}
