<?php

class Areas_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('areas', 'list');

        $model_areas = new Areas();

        $this->view->model_areas = $model_areas;
        $this->view->areas = $model_areas->selectAll();

        history('areas');
        $breadcrumb = array();
        if ($this->acl('areas', array('new', 'delete'))) {
            $breadcrumb['Administrador de areas'] = $this->view->url(array(), 'areas_manager');
        }
        breadcrumb($breadcrumb);
    }
}
