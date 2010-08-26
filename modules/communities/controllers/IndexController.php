<?php

class Communities_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('communities', 'list');

        $communities = Yeah_Adapter::getModel('communities');

        $request = $this->getRequest();
        $page = $request->getParam('page', 1);

        $paginator = Zend_Paginator::factory($communities->selectAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model = $communities;
        $this->view->communities = $paginator;
        $this->view->route = array (
            'key' => 'communities_list',
            'params' => array(),
        );

        history('communities');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('communities', array('list', 'enter'))) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        breadcrumb($breadcrumb);
    }
}
