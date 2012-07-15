<?php

class Packages_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('packages', 'list');

        $db_packages = new Db_Packages();
        $this->view->list = $db_packages->tree();

        $this->history('packages');
        $breadcrumb = array();
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de paquetes'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
