<?php

class Templates_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('templates', 'switch');

        $model_templates = new Templates();

        $this->view->templates = $model_templates->selectAll();

        $this->history('templates');
        breadcrumb();
    }
}
