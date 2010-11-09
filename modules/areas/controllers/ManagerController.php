<?php

class Areas_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('areas', 'list');
        $this->requirePermission('areas', array('new', 'delete'));

        $model_areas = new Areas();

        $this->view->model_areas = $model_areas;
        $this->view->areas = $model_areas->selectAll();

        history('areas/manager');
        $breadcrumb = array();
        if ($this->acl('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('areas', 'new');

        $this->view->area = new Areas_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_areas = new Areas();
            $area = $model_areas->createRow();
            $area->label = $request->getParam('label');
            $area->url = convert($area->label);
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
        if ($this->acl('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        if ($this->acl('areas', array('new', 'delete'))) {
            $breadcrumb['Administrador de areas'] = $this->view->url(array(), 'areas_manager');
        }
        breadcrumb($breadcrumb);
    }
}
