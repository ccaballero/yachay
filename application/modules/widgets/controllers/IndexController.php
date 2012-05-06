<?php

class Widgets_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'list');

        $model_pages = new Pages();
        $model_widgets = new Widgets();
        $model_widgets_pages = new Widgets_Pages();

        $matrix = array();
        foreach ($model_pages->selectAll() as $page) {
            $matrix[$page->ident] = array(
                '1' => new Widgets_Empty(),
                '2' => new Widgets_Empty(),
                '3' => new Widgets_Empty(),
                '4' => new Widgets_Empty(),
            );
            $widgets_in_page = $page->findWidgetsViaWidgets_Pages();
            foreach ($widgets_in_page as $widget) {
                $widget_page = $model_widgets_pages->getPosition($page->ident, $widget->ident);
                $position = $widget_page->position;
                $matrix[$page->ident][$position] = $widget;
            }
        }

        $this->view->model_pages = $model_pages;
        $this->view->pages = $model_pages->selectAll();
        $this->view->model_widgets = $model_widgets;
        $this->view->widgets = $model_widgets->selectAll();
        $this->view->widgets_pages = $matrix;

        $this->history('widgets');
        $breadcrumb = array();
        if ($this->acl('widgets', 'manage')) {
            $breadcrumb['Administrador de widgets'] = $this->view->url(array(), 'widgets_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
