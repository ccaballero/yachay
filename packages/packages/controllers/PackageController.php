<?php

class Packages_PackageController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('packages', 'view');

        $request = $this->getRequest();

        $url = $request->getParam('package');

        $model_packages = new Packages();
        $package = $model_packages->findByUrl($url);

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
        if ($request->isPost()) {
            $url = $request->getParam('package');

            $model_packages = new Packages();
            $package = $model_packages->findByUrl($url);

            $this->requireExistence($package, 'package', 'packages_package_view', 'packages_list');

            if ($package->type != 'base') {
                $model_packages->locks($package->arrayDown());
                $this->_helper->flashMessenger->addMessage("El paquete {$package->label} ha sido deshabilitado");
            }

            $this->_redirect($this->view->currentPage());
        }
    }

    public function unlockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();

        $url = $request->getParam('package');

        $model_packages = new Packages();
        $package = $model_packages->findByUrl($url);

        $this->requireExistence($package, 'package', 'packages_package_view', 'packages_list');

        if ($package->type != 'base') {
            $model_packages->unlocks($package->arrayUp());
            $this->_helper->flashMessenger->addMessage("El paquete {$package->label} ha sido habilitado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
