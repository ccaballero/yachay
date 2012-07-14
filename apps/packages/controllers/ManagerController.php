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
        $this->view->list = $db_packages->getTree();

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
            $tree = $db_packages->getTree();

            $check = $request->getParam('check');
            $packages_check = array();

            foreach ($check as $value) {
                $package = $db_packages->findByIdent($value);
                $node = $tree->getNode($package->url);

                if (!empty($package) && $package->type != 'base') {
                    $list = array();
                    foreach ($node as $children) {
                        $list[] = $children->ident();
                    }

                    $packages_check = array_merge($packages_check, $list);
                }
            }

            if (count($packages_check) > 0) {
                $db_packages->locks($packages_check);
            }

            $count = count($packages_check);
            $this->_helper->flashMessenger->addMessage("Se han desactivado $count modulos");
        }

        $this->_redirect($this->view->currentPage());
    }



    public function unlockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $db_packages = new Db_Packages();
            $tree = $db_packages->getTree();

            $check = $request->getParam('check');
            $packages_check = array();

            foreach ($check as $value) {
                $package = $db_packages->findByIdent($value);
                
                if (!empty($package)) {
                    $path = $tree->path($package->url);

                    $list = array();
                    foreach ($path as $parent) {
                        $list[] = $parent->ident();
                    }

                    $packages_check = array_merge($packages_check, $list);
                }
            }

            if (count($packages_check) > 0) {
                $db_packages->unlocks($packages_check);
            }

            $count = count($packages_check);
            $this->_helper->flashMessenger->addMessage("Se han activado $count modulos");
        }

        $this->_redirect($this->view->currentPage());
    }


}
