<?php

class Communities_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'list');

        $model_communities = new Communities();

        $request = $this->getRequest();
        $page = $request->getParam('page', 1);

        $paginator = Zend_Paginator::factory($model_communities->selectAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->communities = $paginator;
        $this->view->route = array (
            'key' => 'communities_list',
            'params' => array(),
        );

        $this->history('communities');
        $breadcrumb = array();
        if ($this->acl('communities', 'enter')) {
            $breadcrumb['Administrador de comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        breadcrumb($breadcrumb);
    }
}
