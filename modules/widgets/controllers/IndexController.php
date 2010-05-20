<?php

class Widgets_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'list');

        $pages = Yeah_Adapter::getModel('pages');
        $widgets = Yeah_Adapter::getModel('widgets');
        $widgets_pages = Yeah_Adapter::getModel('widgets', 'Widgets_Pages');

        $matrix = array();
        foreach ($pages->selectAll() as $page) {
            $matrix[$page->ident] = array(
                '1' => new modules_widgets_models_Widgets_Empty,
                '2' => new modules_widgets_models_Widgets_Empty,
                '3' => new modules_widgets_models_Widgets_Empty,
                '4' => new modules_widgets_models_Widgets_Empty,
            );
            $widgets_in_page = $page->findManyToManyRowset('modules_widgets_models_Widgets', 'modules_widgets_models_Widgets_Pages');
            foreach ($widgets_in_page as $widget) {
                $widget_page = $widgets_pages->getPosition($page->ident, $widget->ident);
                $position = $widget_page->position;
                $matrix[$page->ident][$position] = $widget;
            }
        }

        $this->view->model = $pages;
        $this->view->pages = $pages->selectAll();
        $this->view->widgets = $widgets->selectAll();
        $this->view->widgets_pages = $matrix;

        history('widgets');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('widgets', 'manage')) {
            $breadcrumb['Widgets'] = $this->view->url(array(), 'widgets_manager');
        }
        breadcrumb($breadcrumb);
    }
}
