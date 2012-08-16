<?php

class Users_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('users', 'list');

        $model_users = new Users();
        $model_friends = new Friends();

        $request = $this->getRequest();
        $page = $request->getParam('page', 1);

        $paginator = Zend_Paginator::factory($model_users->selectByStatus('active'));
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model_users = $model_users;
        $this->view->model_friends = $model_friends;
        $this->view->users = $paginator;
        $this->view->pager = array (
            'key' => 'users_list',
            'params' => array(),
        );

        $this->history('users');
        $breadcrumb = array();
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
