<?php

class Areas_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('areas', 'list');

        $areas = Yeah_Adapter::getModel('areas');

        $this->view->model = $areas;
        $this->view->areas = $areas->selectAll();

        history('areas');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_manager');
        }
        breadcrumb($breadcrumb);
    }
}
