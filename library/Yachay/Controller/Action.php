<?php

abstract class Yachay_Controller_Action extends Yachay_Controller_Require
{
    protected $_useForward = false;

    public function init() {
        parent::init();
    }

    public function preDispatch() {
        // Set the route of request
        $model_routes = new Db_Routes();
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();
        $this->route = $model_routes->findByRoute($route);
        
        // add the views in path
        $this->view->addHelperPath(APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
        $this->view->addHelperPath(APPLICATION_PATH . '/library/Yachay/View/Helper', 'Yachay_View_Helper');
        $this->view->doctype($this->template->doctype);
        if (!isset($this->_ignoreContextDefault)) {
            $this->context('global');
        }

        // Add the helpers of application
        $model_packages = new Db_Packages();
        $packages = $model_packages->selectByType('app');
        foreach ($packages as $package) {
            //FIXME Considerar las posibles alternativas en tipos de modulos
            if ($this->route->controller != 'manager') {
                $this->view->addScriptPath($this->config->resources->frontController->moduleDirectory . '/' . $package->url . '/views/scripts/application');
            }
        }

        $this->view->config = $this->config;
        $this->view->route = $this->route;
        $this->view->user = $this->user;
        $this->view->template = $this->template;
    }

    public function postDispatch() {
        if (isset($this->_ignorePostDispatch)) {
            return;
        }

        global $MENUBAR;
        global $FOOTER;

        $this->renderToolbar();
        $this->renderMenus($MENUBAR, 'menubar');
        $this->renderMenus($FOOTER, 'footer');
        
        // Special add for footer menu
        $FOOTER->items[] = array(
            'link' => 'https://github.com/ccaballero/yachay',
            'label' => 'Codigo fuente',
        );

        $FOOTER->copyright = 'yachay ' . $this->config->system->version;

        // FIXME Control de privilegios
        global $WIDGETS;
        
        $model_routes = new Db_Routes();
        $db_route = $model_routes->findAdapterByRoute($this->route->route);

        $widgets = $db_route->findWidgetsViaWidgets_Routes();

        $model_widgets_routes = new Widgets_Routes();
//        $widgets = $model_widgets_routes->selectByRoute($this->route->route);

        foreach ($widgets as $widget) {
            $view = new Zend_View();
            $view->addHelperPath(
                APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
            $view->setScriptPath(
                $this->config->resources->frontController->moduleDirectory .
                '/' . $widget->package . '/views/scripts/widgets/');

            $view->config = $this->config;
            $view->route = $this->route;
            $view->user = $this->user;
            $view->template = $this->template;

            $widget_page = $model_widgets_routes->getPosition($this->route->route, $widget->ident);
            $position = $widget_page->position;

            $script = $this->config->resources->frontController->moduleDirectory . "/{$widget->package}/views/scripts/widgets/{$widget->script}-{$this->template->label}.php";
            if (file_exists($script)) {
                $to_render = "{$widget->script}-{$this->template->label}.php";
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
        global $TOOLBAR, $SEARCH, $MENUBAR, $BREADCRUMB, $WIDGETS, $FOOTER;

        $this->view->TOOLBAR = $TOOLBAR;
        $this->view->SEARCH = $SEARCH;
        $this->view->MENUBAR = $MENUBAR;
        $this->view->BREADCRUMB = $BREADCRUMB;
        $this->view->WIDGETS = $WIDGETS;
        $this->view->FOOTER = $FOOTER;

        $this->view->messages = array_merge($this->_helper->getHelper('FlashMessenger')->getCurrentMessages(), $this->_helper->getHelper('FlashMessenger')->getMessages());
        $this->_helper->getHelper('FlashMessenger')->clearCurrentMessages();
        $this->_helper->getHelper('FlashMessenger')->clearMessages();

        // Rendering customized theme
        $script = $this->view->getScriptPath($this->route->controller) . '/' . $this->route->action . '-' . $this->template->label . '.php';
        if (file_exists($script)) {
            $this->render($this->route->action . '-' . $this->template->label);
        }
    }

    public function history($url = '') {
        $session = new Zend_Session_Namespace('yachay');
        $session->lastPage = $session->currentPage;
        $session->currentPage = $this->config->resources->frontController->baseUrl . '/' . $url;
    }
    
    public function breadcrumb($elements = array()) {
        global $BREADCRUMB;
        $BREADCRUMB->items[] = array(
            'link'  => $this->config->resources->frontController->baseUrl . '/',
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
    
    public function acl($package, $label) {
        return Yachay_Acl::hasPermission($package, $label);
    }

    public function renderToolbar() {
        global $TOOLBAR;

        $model_roles = new Roles();
        $role = $model_roles->findByIdent($this->user->role);

        $session = new Zend_Session_Namespace('yachay');
        $TOOLBAR->items[] = $this->view->contextLabel($session->context_type, $session->context_label);

        if ($this->user->role == 1) {
            $TOOLBAR->items[] = $role->label;
            $TOOLBAR->items[] = '<a href="' . $this->view->url(array(), 'login_in') . '">Ingresar</a>';
        } else {
            $TOOLBAR->items[] = '<a href="' . $this->view->url(array('user' => $this->user->url), 'profile_view') . '">' . $this->user->getFullName() . '</a>';
            $TOOLBAR->items[] = '<a href="' . $this->view->url(array('user' => $this->user->url), 'settings') . '">Preferencias</a>';
            $TOOLBAR->items[] = '<a href="' . $this->view->url(array(), 'login_out') . '">Salir</a>';
        }
    }

    public function renderMenus($container, $type) {
        $model_routes = new Db_Routes();
        $model_routes_privileges = new Db_Routes_Privileges();

        $items = $model_routes->selectByMenu($type);

        foreach ($items as $item) {
            $privileges = $model_routes_privileges->findByRoute($item->route);

            if (count($privileges) == 0) {
                $bool = true;
            } else {
                $bool = false;
                foreach ($privileges as $privilege) {
                    $bool |= $this->user->hasPermission($privilege->package, $privilege->privilege);
                }
            }

            if ($bool) {
                $container->items[] = array (
                    'link'  => $this->view->url(array(), $item->route),
                    'label' => ucfirst($item->label),
                );
            }
        }
    }
}
