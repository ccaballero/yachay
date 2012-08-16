<?php

class Widgets_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'manage');

        $model_routes = new Db_Routes();
        $model_widgets = new Widgets();
        $model_widgets_routes = new Widgets_Routes();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $config = $request->getParam('widgets');
            foreach ($config as $route_ident => $array_widgets) {
                $route = $model_routes->findAdapterByIdent($route_ident);
                if (!empty($route)) {
                    // delete of widgets in route
                    $model_widgets_routes->deleteWidgetsInRoute($route->route);
                    // set of new configuration
                    foreach ($array_widgets as $position => $widget_ident) {
                        $widget = $model_widgets->findByIdent($widget_ident);
                        $position = intval($position);
                        if (!empty($widget) && is_int($position) && 0 < $position && $position <= 4) {
                            $widget_route = $model_widgets_routes->createRow();
                            $widget_route->route = $route->route;
                            $widget_route->widget = $widget->ident;
                            $widget_route->position = "$position";
                            $widget_route->save();
                        }
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage('Su configuración de los widgets ha sido almacenada');
        } else {
            $this->history('widgets/manager');
        }

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

        $breadcrumb = array();
        if ($this->acl('widgets', 'list')) {
            $breadcrumb['Widgets'] = $this->view->url(array(), 'widgets_list');
        }
        $this->breadcrumb($breadcrumb);
    }
}
