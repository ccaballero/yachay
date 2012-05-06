<?php

class Widgets_ManagerController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'manage');

        $model_pages = new Pages();
        $model_widgets = new Widgets();
        $model_widgets_pages = new Widgets_Pages();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $config = $request->getParam('widgets');
            foreach ($config as $page_ident => $array_widgets) {
                $page = $model_pages->findByIdent($page_ident);
                if (!empty($page)) {
                    // delete of widgets in page
                    $model_widgets_pages->deleteWidgetsInPage($page->ident);
                    // set of new configuration
                    foreach ($array_widgets as $position => $widget_ident) {
                        $widget = $model_widgets->findByIdent($widget_ident);
                        $position = intval($position);
                        if (!empty($widget) && is_int($position) && 0 < $position && $position <= 4) {
                            $widget_page = $model_widgets_pages->createRow();
                            $widget_page->page = $page->ident;
                            $widget_page->widget = $widget->ident;
                            $widget_page->position = "$position";
                            $widget_page->save();
                        }
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage('Su configuración de los widgets ha sido almacenada');
        }

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

        $this->history('widgets/manager');
        $breadcrumb = array();
        if ($this->acl('widgets', 'list')) {
            $breadcrumb['Widgets'] = $this->view->url(array(), 'widgets_list');
        }
        $this->breadcrumb($breadcrumb);
    }
}
