<?php

class Templates_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('templates', 'switch');

        $model_templates = new Templates();

        $this->view->templates = $model_templates->selectAll();

        history('templates');
        breadcrumb();
    }
}
