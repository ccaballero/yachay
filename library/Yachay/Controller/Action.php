<?php

abstract class Yachay_Controller_Action extends Yachay_Controller_Require
{
    public function init() {
        parent::init();
    }

    public function preDispatch() {
        // settings for the page
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();
        if ($route == 'default') {
            return;
        }

        $model_pages = new Pages();
        global $PAGE;
        $PAGE = $model_pages->findByRoute($route);

        // add the views in path
        $this->view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');

        global $TEMPLATE;
        $this->view->doctype($TEMPLATE->doctype);

        if (empty($PAGE)) {
            return;
        }

        // Set context by default
        if (!isset($this->_ignoreContextDefault)) {
            $this->context('global');
        }

        // Add the helpers of application
        $model_modules = new Modules();
        $modules = $model_modules->selectByType('application');
        foreach ($modules as $module) {
            //FIXME Considerar las posibles alternativas en tipos de modulos
            if ($PAGE->controller != 'manager') {
                $this->view->addScriptPath(APPLICATION_PATH . '/modules/' . $module->url . '/views/scripts/application');
            }
        }

        // Regions settings
        global $TITLE;
        $TITLE->title = $this->config->yachay->properties->title;

        global $ICON;
        $ICON->icon = $this->config->resources->frontController->baseUrl . '/media/favicon.ico';

        $this->view->config = $this->config;
        $this->view->user = $this->user;
        $this->view->PAGE = $PAGE;
        $this->view->TEMPLATE = $TEMPLATE;
    }

    public function postDispatch() {
        if (isset($this->_ignorePostDispatch)) {
            return;
        }

        global $PAGE;
        if (empty($PAGE)) {
            return;
        }

        global $TEMPLATE;
        global $WIDGETS;

        $regions = $PAGE->findRegionsViaRegions_Pages();
        if (!empty($regions)) {
            foreach ($regions as $region) {
                $view = new Zend_View();
                $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
                $view->setScriptPath(APPLICATION_PATH . '/modules/' . $region->module . '/views/scripts/' . $region->region . '/');

                $view->config = $this->config;
                $view->user = $this->user;
                $view->PAGE = $PAGE;
                $view->TEMPLATE = $TEMPLATE;

                $view->render($region->script . '.php');
            }
        }

        // FIXME Control de privilegios
        $widgets = $PAGE->findWidgetsViaWidgets_Pages();
        $model_widgets_pages = new Widgets_Pages();
        foreach ($widgets as $widget) {
            $view = new Zend_View();
            $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
            $view->setScriptPath(APPLICATION_PATH . '/modules/' . $widget->module . '/views/scripts/widgets/');
            
            $view->config = $this->config;
            $view->user = $this->user;
            $view->PAGE = $PAGE;
            $view->TEMPLATE = $TEMPLATE;

            $widget_page = $model_widgets_pages->getPosition($PAGE->ident, $widget->ident);
            $position = $widget_page->position;

            $script = APPLICATION_PATH . "/modules/{$widget->module}/views/scripts/widgets/{$widget->script}-{$TEMPLATE->label}.php";
            if (file_exists($script)) {
                $to_render = "{$widget->script}-{$TEMPLATE->label}.php";
            } else {
                $to_render = "{$widget->script}.php";
            }
            $widget_content = $view->render($to_render);
            if (!empty($widget_content)) {
                $WIDGETS[$position] = array (
                    'title'   => $widget->title,
                    'content' => $widget_content,
                );
            }
        }
        
        // Register last login
        $this->user->lastLogin();
        if ($this->user->needFillProfile()) {
            $this->_helper->flashMessenger->addMessage('Se recomienda que ingrese su nombre, apellido y correo electrónico. <a href="' . $this->view->url(array(), 'profile_edit') . '">Editar</a>');
        }

        // Assign global variables to view
        global $TITLE, $ICON, $TOOLBAR, $SEARCH, $MENUBAR, $BREADCRUMB, $WIDGETS, $FOOTER;

        $this->view->TITLE = $TITLE;
        $this->view->ICON = $ICON;
        $this->view->TOOLBAR = $TOOLBAR;
        $this->view->SEARCH = $SEARCH;
        $this->view->MENUBAR = $MENUBAR;
        $this->view->BREADCRUMB = $BREADCRUMB;
        $this->view->WIDGETS = $WIDGETS;
        $this->view->FOOTER = $FOOTER;

        $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();

        // Rendering customized theme
        $script = $this->view->getScriptPath($PAGE->controller) . '/' . $PAGE->action . '-' . $TEMPLATE->label . '.php';
        if (file_exists($script)) {
            $this->render($PAGE->action . '-' . $TEMPLATE->label);
        }
    }

    public function history($url_page = '') {
        $session = new Zend_Session_Namespace('yachay');
        $session->lastPage = $session->currentPage;
        $session->currentPage = $this->config->resources->frontController->baseUrl . '/' . $url_page;
    }
    
    public function breadcrumb($elements = array()) {
        global $BREADCRUMB;
        $BREADCRUMB->items[] = array(
            'link'  => $this->config->resources->frontController->baseUrl,
            'label' => 'Inicio',
        );

        foreach ($elements as $element => $url) {
            $BREADCRUMB->items[] = array(
                'link' => $url,
                'label' => $element,
            );
        }
    }
    
    public function context($type, $value = null) {
        $session = new Zend_Session_Namespace('yachay');

        $session->context_type = $type;
        if ($type <> 'global') {
            $session->context_id = $value->ident;
            $session->context_label = $value->label;
        } else {
            $session->context_id = 0;
            $session->context_label = '';
        }
    }
    
    public function acl($module, $privilege) {
        return Yachay_Acl::hasPermission($module, $privilege);
    }
}
