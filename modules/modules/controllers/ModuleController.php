<?php

class Modules_ModuleController extends Yeah_Action
{
    public function viewAction() {
        global $CONFIG;

        $this->requirePermission('modules', 'view');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $modules = Yeah_Adapter::getModel('modules');
        $module = $modules->findByUrl($url);
        
        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $init = $CONFIG->dirroot . 'modules/' . $module->url . '/Init.php';
        if (file_exists($init)) {
            $class = "modules_{$module->url}_Init";
            $model = new $class;
        }
        $this->view->module = $module;
        $this->view->model = $model;

        history('modules/' . $module->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('modules', array('new', 'lock'))) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_manager');
        } else if (Yeah_Acl::hasPermission('modules', 'list')) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_list');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('modules', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $modules = Yeah_Adapter::getModel('modules');
        $module = $modules->findByUrl($url);

        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $module->status = 'inactive';
        $module->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El modulo {$module->label} ha sido deshabilitado");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('modules', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $modules = Yeah_Adapter::getModel('modules');
        $module = $modules->findByUrl($url);

        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $module->status = 'active';
        $module->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El modulo {$module->label} ha sido habilitado");

        $this->_redirect($this->view->currentPage());
    }
}
