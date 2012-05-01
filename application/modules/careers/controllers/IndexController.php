<?php

class Careers_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('careers', 'list');

        $model_careers = new Careers();

        $this->view->model_careers = $model_careers;
        $this->view->careers = $model_careers->selectAll();

        $this->history('careers');
        $breadcrumb = array();
        if ($this->acl('careers', array('new', 'delete'))) {
            $breadcrumb['Administrador de carreras'] = $this->view->url(array(), 'careers_manager');
        }
        breadcrumb($breadcrumb);
    }
}
