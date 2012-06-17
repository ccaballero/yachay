<?php

class Packages_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('packages', 'list');

        $model_packages = new Packages();

        $this->view->model_packages = $model_packages;
        $this->view->packages = $model_packages->selectAll();

        $this->history('packages');
        $breadcrumb = array();
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
