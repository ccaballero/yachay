<?php

class Gestions_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('gestions', 'list');

        $model_gestions = new Gestions();

        $this->view->model_gestions = $model_gestions;
        $this->view->gestions = $model_gestions->selectAll();

        $this->history('gestions');
        $breadcrumb = array();
        if ($this->acl('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Administrador de gestiones'] = $this->view->url(array(), 'gestions_manager');
        }
        breadcrumb($breadcrumb);
    }
}
