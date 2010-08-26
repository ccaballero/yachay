<?php

class Users_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('users', 'list');

        $users = Yeah_Adapter::getModel('users');
        $friends = Yeah_Adapter::getModel('friends');

        $request = $this->getRequest();
        $page = $request->getParam('page', 1);

        $paginator = Zend_Paginator::factory($users->selectByStatus('active'));
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model = $users;
        $this->view->friends = $friends;
        $this->view->users = $paginator;
        $this->view->route = array (
            'key' => 'users_list',
            'params' => array(),
        );

        history('users');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        }
        breadcrumb($breadcrumb);
    }
}
