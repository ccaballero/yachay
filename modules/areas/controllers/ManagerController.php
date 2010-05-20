<?php

class Areas_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('areas', 'list');
        $this->requirePermission('areas', array('new', 'delete'));

        $areas = Yeah_Adapter::getModel('areas');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('gestions', 'active')) {
                $gestion_ident = $request->getParam('radio');
                $gestion = $gestions->findByIdent($gestion_ident);
                if ($gestion->status == 'inactive') {
                    // clear all gestions
                    $gestions->desactiveAll();
                    // Active the selected gestion
                    $gestion->status = 'active';
                    $gestion->save();
                }
                $session = new Zend_Session_Namespace();
                $session->messages->addMessage("La gestion {$gestion->label} ha sido establecida como actual");
            }
        }

        $this->view->model = $areas;
        $this->view->areas = $areas->selectAll();

        history('areas/manager');
        breadcrumb();
    }

    public function newAction() {
        $this->requirePermission('areas', 'new');

        $this->view->area = new modules_areas_models_Areas_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $areas = Yeah_Adapter::getModel('areas');
            $area = $areas->createRow();
            $area->label = $request->getParam('label');
            $area->description = $request->getParam('description');

            if ($area->isValid()) {
                $area->tsregister = time();
                $area->save();
                $session->messages->addMessage("El area {$area->label} se ha creado correctamente");
                $session->url = $area->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
            
            $this->view->area = $area;
        }

        history('areas/new');
        $breadcrumb = array();
        $breadcrumb['Areas'] = $this->view->url(array(), 'areas_manager');
        breadcrumb($breadcrumb);
    }
}
