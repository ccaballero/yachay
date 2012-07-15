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

        $db_packages = new Db_Packages();
        $this->view->list = $db_packages->tree();

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
            $db_packages = new Db_Packages();
            $tree = $db_packages->tree();

            $check = $request->getParam('check');
            $list = array();

            foreach ($check as $ident) {
                $package = $db_packages->findByIdent($ident);

                if (!empty($package) && $package->type != 'base') {
                    $node = $tree->getNode($package->url);

                    $sub_list = array();
                    foreach ($node as $children) {
                        $sub_list[] = $children->ident;
                    }

                    $list = array_merge($sub_list, $list);
                }
            }

            $count = $db_packages->lock($list);
            $this->_helper->flashMessenger->addMessage("Se han desactivado $count paquetes");
        }

        $this->_redirect($this->view->currentPage());
    }



    public function unlockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $db_packages = new Db_Packages();
            $tree = $db_packages->tree();

            $check = $request->getParam('check');
            $list = array();

            foreach ($check as $ident) {
                $package = $db_packages->findByIdent($ident);

                if (!empty($package) && $package->type != 'base') {
                    $path = $tree->path($package->url);

                    $sub_list = array();
                    foreach ($path as $parent) {
                        $sub_list[] = $parent->ident;
                    }

                    $list = array_merge($sub_list, $list);
                }
            }

            $count = $db_packages->unlock($list);
            $this->_helper->flashMessenger->addMessage("Se han activado $count paquetes");
        }

        $this->_redirect($this->view->currentPage());
    }
}