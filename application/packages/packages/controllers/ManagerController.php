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

        $this->view->model_packages = $model_packages;
        $this->view->packages = $model_packages->selectAll();

        $breadcrumb = array();
        if ($this->acl('packages', 'list')) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'packages_list');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('packages', 'new');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/../data/upload/');
            $upload->addValidator('Size', false, 2097152)
                   ->addValidator('Extension', false, array('zip'));

            if ($upload->receive()) {
                $filename = $upload->getFileName('file');
                $zip = new ZipArchive;
                $zip->open($filename);
                $zip->extractTo('./packages');
                $zip->close(); 

                $file = $upload->getFileInfo();
                $package = $file['file']['name'];
                $package = substr($package, 0, -4);

                $oldsql = "./packages/$package/$package.sql";
                $newsql = "./sql/$package.sql";
                if (rename($oldsql, $newsql)) {
                    //mysql_import(APPLICATION_PATH . '/../data/sql/' . $package . '.sql');
                }
                $this->_helper->flashMessenger->addMessage('El modulo ha sido añadido');
                unlink($filename);
            } else {
                $this->_helper->flashMessenger->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
            }
            $this->_redirect($this->view->currentPage());
        } else {
            $this->history('packages/new');
        }

        $breadcrumb = array();
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('packages', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_packages = new Packages();
            $check = $request->getParam("check");
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
            $check = $request->getParam("check");
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
