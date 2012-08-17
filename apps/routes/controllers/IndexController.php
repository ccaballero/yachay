<?php

class Routes_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('routes', 'list');

        $model_routes = new Db_Routes();

        $this->view->model_routes = $model_routes;
        $this->view->routes = $model_routes->selectAll();

        $this->history('routes');
        $breadcrumb = array();
        if ($this->acl('routes', 'manage')) {
            $breadcrumb['Administrador de rutas'] = $this->view->url(array(), 'routes_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
