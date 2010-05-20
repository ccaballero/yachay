<?php

class Gestions_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('gestions', 'list');

        $gestions = Yeah_Adapter::getModel('gestions');

        $this->view->model = $gestions;
        $this->view->gestions = $gestions->selectAll();

        history('gestions');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_manager');
        }
        breadcrumb($breadcrumb);
    }
}
