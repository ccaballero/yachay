<?php

class Packages_PackageController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('packages', 'view');

        $request = $this->getRequest();

        $url = $request->getParam('package');

        $db_packages = new Db_Packages();
        $package = $db_packages->findByUrl($url);

        $this->requireExistence($package, 'package', 'packages_package_view', 'packages_list');

        $this->view->package = $package;

        $this->history('packages/' . $package->url);
        $breadcrumb = array();
        if ($this->acl('packages', 'list')) {
            $breadcrumb['Paquetes'] = $this->view->url(array(), 'packages_list');
        }
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de paquetes'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        $url = $request->getParam('package');

        $db_packages = new Db_Packages();
        $package = $db_packages->findByUrl($url);

        $this->requireExistence($package, 'package', 'packages_package_view', 'packages_list');

        if ($request->isPost()) {
            $return = $request->getParam('return');

            if ($package->type != 'base') {
                $tree = $db_packages->tree();
                $node = $tree->getNode($package->url);

                $list = array();
                foreach ($node as $children) {
                    $list[] = $children->ident;
                }

                $count = $db_packages->lock($list);
                if ($count <> 0) {
                    $this->_helper->flashMessenger->addMessage("El paquete {$package->label} ha sido deshabilitado");
                }
            }

            if (!empty($return)) {
                $this->_redirect($return);
            } else {
                $this->_redirect($this->view->currentPage());
            }
        } else {
            $session = new Zend_Session_Namespace('yachay');
            $session->confirm = array(
                'message' => '¿Esta seguro que quiere deshabilitar el paquete ' . $package->label . '?',
                'return'  => $this->view->url(array('package' => $package->url), 'packages_package_lock'),
            );

            $this->_redirect($this->view->url(array(), 'base_confirm'));
        }
    }

    public function unlockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        $url = $request->getParam('package');

        $db_packages = new Db_Packages();
        $package = $db_packages->findByUrl($url);

        $this->requireExistence($package, 'package', 'packages_package_view', 'packages_list');

        if ($request->isPost()) {
            $return = $request->getParam('return');

            if ($package->type != 'base') {
                $tree = $db_packages->tree();
                $path = $tree->path($package->url);

                $list = array();
                foreach ($path as $parent) {
                    $list[] = $parent->ident;
                }

                $count = $db_packages->unlock($list);
                if ($count <> 0) {
                    $this->_helper->flashMessenger->addMessage("El paquete {$package->label} ha sido habilitado");
                }
            }

            if (!empty($return)) {
                $this->_redirect($return);
            } else {
                $this->_redirect($this->view->currentPage());
            }
        } else {
            $session = new Zend_Session_Namespace('yachay');
            $session->confirm = array(
                'message' => '¿Esta seguro que quiere habilitar el paquete ' . $package->label . '?',
                'return'  => $this->view->url(array('package' => $package->url), 'packages_package_unlock'),
            );

            $this->_redirect($this->view->url(array(), 'base_confirm'));
        }
    }
}
