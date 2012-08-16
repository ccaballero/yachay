<?php

class Widgets_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'list');

        $model_routes = new Db_Routes();
        $model_widgets = new Widgets();
        $model_widgets_routes = new Widgets_Routes();

        $matrix = array();
        foreach ($model_routes->selectByRenderable() as $route) {
            $matrix[$route->ident] = array(
                '1' => new Widgets_Empty(),
                '2' => new Widgets_Empty(),
                '3' => new Widgets_Empty(),
                '4' => new Widgets_Empty(),
            );
            $widgets_in_route = $route->findWidgetsViaWidgets_Routes();
            foreach ($widgets_in_route as $widget) {
                $widget_route = $model_widgets_routes->getPosition($route->route, $widget->ident);
                $position = $widget_route->position;
                $matrix[$route->ident][$position] = $widget;
            }
        }

        $this->view->model_routes = $model_routes;
        $this->view->routes = $model_routes->selectByRenderable();
        $this->view->model_widgets = $model_widgets;
        $this->view->widgets = $model_widgets->selectAll();
        $this->view->widgets_routes = $matrix;

        $this->history('widgets');
        $breadcrumb = array();
        if ($this->acl('widgets', 'manage')) {
            $breadcrumb['Administrador de widgets'] = $this->view->url(array(), 'widgets_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
