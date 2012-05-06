<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
        return $config;
    }

    protected function _initAutoload() {
        $this->bootstrap('config');
        
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->pushAutoloader(new Yachay_Loader());
        return $loader;
    }

    protected function _initRouter() {
        $this->bootstrap('autoload');
        $this->bootstrap('frontController');
        $this->bootstrap('db');

        $ctrl = Zend_Controller_Front::getInstance();
        $router = $ctrl->getRouter();

        // Routes join
        $model_modules = new Modules();
        $modules = $model_modules->selectByStatus('active');
        foreach ($modules as $module) {
            $path = APPLICATION_PATH . '/modules/' . $module->url;
            if (is_dir($path)) {
                if (file_exists("$path/Init.php")) {
                    include "$path/Init.php";
                    $class = ucfirst(strtolower($module->url)) . '_Init';
                    $obj = new $class();
                    $obj->setRoutes($router);
                }
            }
        }

        return $router;
    }

    protected function _initSession() {
        Zend_Session::start();
    }
    
    protected function _initLocale() {
        $this->bootstrap('config');
        $config = Zend_Registry::get('config');
        // Set for localization
        setlocale(LC_CTYPE, $config->yachay->properties->locale);
        Zend_Locale::setDefault($config->yachay->properties->locale);
    }
    
    protected function _initTimezone() {
        $this->bootstrap('config');
        $config = Zend_Registry::get('config');
        date_default_timezone_set($config->yachay->properties->timezone);
    }
    
    protected function _initUser() {
        $this->bootstrap('autoload');
        $this->bootstrap('session');
        
        $session = new Zend_Session_Namespace('yachay');
        // Set for user information, if exists
        global $USER;
        if (isset($session->user)) {
            $USER = $session->user;
        } else {
            $USER = new Users_Visitor();
        }
    }
    
    protected function _initContext() {
        $this->bootstrap('session');
        
        $session = new Zend_Session_Namespace('yachay');
        if (!isset($session->context)) {
            $session->context_type = 'global';
        }
        if (!isset($session->context_label)) {
            $session->context_label = '';
        }
        if (!isset($session->context_id)) {
            $session->context_id = 0;
        }
    }
    
    protected function _initHistory() {
        $this->bootstrap('config');
        $this->bootstrap('session');

        $config = Zend_Registry::get('config');

        $session = new Zend_Session_Namespace('yachay');
        if (!isset($session->currentPage)) {
            $session->currentPage = $config->resources->frontController->baseUrl;
        }
        if (!isset($session->lastPage)) {
            $session->lastPage = $config->resources->frontController->baseUrl;
        }
    }
    
    protected function _initTemplate() {
        $this->bootstrap('autoload');
        $this->bootstrap('user');

        // Set of theme
        global $TEMPLATE;
        global $USER;
        
        $config = Zend_Registry::get('config');

        $model_templates = new Templates();
        $template = $model_templates->findByLabel($USER->template);

        $TEMPLATE = new StdClass();
        $TEMPLATE->label = $template->label;
        $TEMPLATE->parent = $template->parent;
        $TEMPLATE->doctype = $template->doctype;
        $TEMPLATE->description = $template->description;
        $TEMPLATE->css_properties = $template->css_properties;
        $TEMPLATE->htmlbase = $config->resources->frontController->baseUrl . '/templates/' . $TEMPLATE->label . '/';

        global $PALETTE;
        $model_templates_users = new Templates_Users();
        $template_user = $model_templates_users->findByTemplateAndUser($template->ident, $USER->ident);
        if (empty($template_user)) {
            $template_user = $template;
        }
        $PALETTE = json_decode($template_user->css_properties, true);
    }
    
    protected function _initPlaceholder() {
        // Set of web regions
        global $TITLE;
        $TITLE = new Yachay_Regions_Title();
        global $ICON;
        $ICON = new Yachay_Regions_Icon();
        global $TOOLBAR;
        $TOOLBAR = new Yachay_Regions_Toolbar();
        global $SEARCH;
        $SEARCH = new Yachay_Regions_Search();
        global $MENUBAR;
        $MENUBAR = new Yachay_Regions_Menubar();
        global $BREADCRUMB;
        $BREADCRUMB = new Yachay_Regions_Breadcrumb();
        global $FOOTER;
        $FOOTER = new Yachay_Regions_Footer();
        // Set of web widgets
        global $WIDGETS;
        $WIDGETS = array(1=>'',2=>'',3=>'',4=>'');
    }

    protected function _initView() {
        $this->bootstrap('frontController');
        
        // Use the php suffix in views
        $renderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $renderer->setViewSuffix('php');
        Zend_Controller_Action_HelperBroker::addHelper($renderer);

        $view = new Zend_View();
        return $view;
    }
    
    protected function _initLayout() {
        $this->bootstrap('template');
        
        global $TEMPLATE;
        
        $options = $this->getOptions();
        $options = $options['resources']['layout'];

        $layout = Zend_Layout::startMVC(array(
            'layoutPath' => APPLICATION_PATH . '/layouts/scripts/',
            'layout' => $TEMPLATE->label,
            'viewSuffix' => 'php',
        ));
        
        return $layout;
    }
}
