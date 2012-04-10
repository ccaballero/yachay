<?php

class Modules_ManagerController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('modules', 'list');
        $this->requirePermission('modules', array('new', 'lock'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('modules', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
        }

        $model_modules = new Modules();

        $this->view->model_modules = $model_modules;
        $this->view->modules = $model_modules->selectAll();

        history('modules/manager');
        $breadcrumb = array();
        if ($this->acl('modules', 'list')) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_list');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('modules', 'new');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination(APPLICATION_PATH . '/../public/media/upload');
            $upload->addValidator('Size', false, 2097152)
                   ->addValidator('Extension', false, array('zip'));

            if ($upload->receive()) {
                $filename = $upload->getFileName('file');
                $zip = new ZipArchive;
                $zip->open($filename);
                $zip->extractTo('./modules');
                $zip->close(); 

                $file = $upload->getFileInfo();
                $module = $file['file']['name'];
                $module = substr($module, 0, -4);

                $oldsql = "./modules/$module/$module.sql";
                $newsql = "./sql/$module.sql";
                if (rename($oldsql, $newsql)) {
                    //mysql_import(APPLICATION_PATH . '/../data/sql/' . $module . '.sql');
                }
                $session->messages->addMessage('El modulo ha sido añadido');
                unlink($filename);
            } else {
                $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
            }
            $this->_redirect($this->view->currentPage());
        }

        history('modules/new');
        $breadcrumb = array();
        if ($this->acl('modules', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'modules_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('modules', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_modules = new Modules();
            $check = $request->getParam("check");
            foreach ($check as $value) {
                $module = $model_modules->findByIdent($value);
                $module->status = 'inactive';
                $module->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han desactivado $count modulos");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('modules', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_modules = new Modules();
            $check = $request->getParam("check");
            foreach ($check as $value) {
                $module = $model_modules->findByIdent($value);
                $module->status = 'active';
                $module->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han activado $count modulos");
        }
        $this->_redirect($this->view->currentPage());
    }
}
