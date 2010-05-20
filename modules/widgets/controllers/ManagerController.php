<?php

class Widgets_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('widgets', 'manage');

        $pages = Yeah_Adapter::getModel('pages');
        $widgets = Yeah_Adapter::getModel('widgets');
        $widgets_pages = Yeah_Adapter::getModel('widgets', 'Widgets_Pages');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $config = $request->getParam('widgets');
            foreach ($config as $page_ident => $array_widgets) {
                $page = $pages->findByIdent($page_ident);
                if (!empty($page)) {
                    // delete of widgets in page
                    $widgets_pages->deleteWidgetsInPage($page->ident);
                    // set of new configuration
                    foreach ($array_widgets as $position => $widget_ident) {
                        $widget = $widgets->findByIdent($widget_ident);
                        $position = intval($position);
                        if (!empty($widget) && is_int($position) && 0 < $position && $position <= 4) {
                            $widget_page = $widgets_pages->createRow();
                            $widget_page->page = $page->ident;
                            $widget_page->widget = $widget->ident;
                            $widget_page->position = "$position";
                            $widget_page->save();
                        }
                    }
                }
            }

            $session->messages->addMessage('Su configuraci&oacute;n de los widgets ha sido almacenada');
        }

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
        breadcrumb();
    }
}
