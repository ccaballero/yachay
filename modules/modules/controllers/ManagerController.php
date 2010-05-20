<?php

class Modules_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('modules', 'list');
        $this->requirePermission('modules', array('new', 'lock'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('modules', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
        }

        $modules = Yeah_Adapter::getModel('modules');

        $this->view->model = $modules;
        $this->view->modules = $modules->selectAll();

        history('modules/manager');
        breadcrumb();
    }

    public function newAction() {
        global $CONFIG;
        $this->requirePermission('modules', 'new');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($CONFIG->dirroot . 'media/upload');
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
                    mysql_import($CONFIG->dirroot . 'sql/' . $module . '.sql');
                }
                $session = new Zend_Session_Namespace();
                $session->messages->addMessage("El modulo ha sido a&ntilde;adido");
                unlink($filename);
            }
            $this->_redirect($this->view->currentPage());
        }

        history('modules/new');
        $breadcrumb = array();
        $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_manager');
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('modules', 'lock');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $modules = Yeah_Adapter::getModel('modules');
            $check = $request->getParam("check");
            foreach ($check as $value) {
                $module = $modules->findByIdent($value);
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
            $modules = Yeah_Adapter::getModel('modules');
            $check = $request->getParam("check");
            foreach ($check as $value) {
                $module = $modules->findByIdent($value);
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
