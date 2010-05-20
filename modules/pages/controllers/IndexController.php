<?php

class Pages_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('pages', 'list');

        $pages = Yeah_Adapter::getModel('pages');

        $this->view->model = $pages;
        $this->view->pages = $pages->selectAll();

        history('pages');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('pages', 'manage')) {
            $breadcrumb['Paginas'] = $this->view->url(array(), 'pages_manager');
        }
        breadcrumb($breadcrumb);
    }
}
