<?php

class Pages_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('pages', 'list');

        $model_pages = new Pages();

        $this->view->model_pages = $model_pages;
        $this->view->pages = $model_pages->selectAll();

        history('pages');
        $breadcrumb = array();
        if ($this->acl('pages', 'manage')) {
            $breadcrumb['Administrador de paginas'] = $this->view->url(array(), 'pages_manager');
        }
        breadcrumb($breadcrumb);
    }
}
