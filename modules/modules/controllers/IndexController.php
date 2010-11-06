<?php

class Modules_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('modules', 'list');

        $model_modules = new Modules();

        $this->view->model_modules = $model_modules;
        $this->view->modules = $model_modules->selectAll();

        history('modules');
        $breadcrumb = array();
        if ($this->acl('modules', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'modules_manager');
        }
        breadcrumb($breadcrumb);
    }
}
