<?php

class Packages_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
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

        $model_packages = new Packages();
        $this->view->tree = $model_packages->getTree();

        $breadcrumb = array();
        if ($this->acl('packages', 'list')) {
            $breadcrumb['Paquetes'] = $this->view->url(array(), 'packages_list');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_packages = new Packages();
            $check = $request->getParam('check');
            foreach ($check as $value) {
                $package = $model_packages->findByIdent($value);
                $package->status = 'inactive';
                $package->save();
            }
            $count = count($check);

            $this->_helper->flashMessenger->addMessage("Se han desactivado $count modulos");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_packages = new Packages();
            $check = $request->getParam('check');
            foreach ($check as $value) {
                $package = $model_packages->findByIdent($value);
                $package->status = 'active';
                $package->save();
            }
            $count = count($check);

            $this->_helper->flashMessenger->addMessage("Se han activado $count modulos");
        }

        $this->_redirect($this->view->currentPage());
    }
}
