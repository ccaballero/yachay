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

    public function managerAction() {
        $this->requirePermission('packages', 'list');
        $this->requirePermission('packages', array('new', 'lock'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('packages', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
        } else {
            $this->history('packages/manager');
        }

        $db_packages = new Db_Packages();
        $this->view->list = $db_packages->tree();

        $breadcrumb = array();
        if ($this->acl('packages', 'list')) {
            $breadcrumb['Paquetes'] = $this->view->url(array(), 'packages_list');
        }
        $this->breadcrumb($breadcrumb);
    }
}
