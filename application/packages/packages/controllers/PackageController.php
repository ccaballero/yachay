<?php

class Packages_PackageController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('packages', 'view');

        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_packages = new Packages();
        $model_pages = new Pages();
        $package = $model_packages->findByUrl($url);

        $this->requireExistence($package, 'mod', 'packages_package_view', 'packages_list');

        $init = APPLICATION_PATH . '/packages/' . $package->url . '/Init.php';
        $model = null;
        if (file_exists($init)) {
            $class = ucfirst(strtolower($package->url)) . '_Init';
            $model = new $class;
        }
        $this->view->model_packages = $model_packages;
        $this->view->model_pages = $model_pages;
        $this->view->package = $package;
        $this->view->routes = $model;

        $this->history('packages/' . $package->url);
        $breadcrumb = array();
        if ($this->acl('packages', 'list')) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'packages_list');
        }
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('packages', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_packages = new Packages();
        $package = $model_packages->findByUrl($url);

        $this->requireExistence($package, 'mod', 'packages_package_view', 'packages_list');

        $package->status = 'inactive';
        $package->save();

        $this->_helper->flashMessenger->addMessage("El modulo {$package->label} ha sido deshabilitado");
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('packages', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_packages = new Packages();
        $package = $model_packages->findByUrl($url);

        $this->requireExistence($package, 'mod', 'packages_package_view', 'packages_list');

        $package->status = 'active';
        $package->save();

        $this->_helper->flashMessenger->addMessage("El modulo {$package->label} ha sido habilitado");
        $this->_redirect($this->view->currentPage());
    }
}
