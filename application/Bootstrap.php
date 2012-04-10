<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() {
        require_once APPLICATION_PATH . '/../library/Yachay/Utils.php';

        global $CONFIG;
        $CONFIG = new Yachay_Settings_Config();

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
        global $CONFIG;
        
        // Set for localization
        setlocale(LC_CTYPE, $CONFIG->locale);
        Zend_Locale::setDefault($CONFIG->locale);
    }
    
    protected function _initTimezone() {
        global $CONFIG;
        date_default_timezone_set($CONFIG->time_zone);
    }
    
    protected function _initUser() {
        $this->bootstrap('autoload');
        $this->bootstrap('session');
        
        $session = new Zend_Session_Namespace();
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
        
        $session = new Zend_Session_Namespace();
        // Set for context information
        if (!isset($session->context)) {
            $session->context = new Yachay_Settings_Context();
        }
    }
    
    protected function _initHistory() {
        $this->bootstrap('session');

        $session = new Zend_Session_Namespace();
        // Set of history of navigation
        if (!isset($session->history)) {
            $session->history = new Yachay_Settings_History();
        }
    }
    
    protected function _initTemplate() {
        $this->bootstrap('autoload');
        $this->bootstrap('user');

        // Set of theme
        global $TEMPLATE;
        global $USER;
        global $CONFIG;

        $model_templates = new Templates();
        $template = $model_templates->findByLabel($USER->template);

        $TEMPLATE = new StdClass();
        $TEMPLATE->label = $template->label;
        $TEMPLATE->parent = $template->parent;
        $TEMPLATE->doctype = $template->doctype;
        $TEMPLATE->description = $template->description;
        $TEMPLATE->css_properties = $template->css_properties;
        $TEMPLATE->htmlbase = $CONFIG->wwwroot . 'templates/' . $TEMPLATE->label . '/';

        global $PALETTE;
        $model_templates_users = new Templates_Users();
        $template_user = $model_templates_users->findByTemplateAndUser($template->ident, $USER->ident);
        if (empty($template_user)) {
            $template_user = $template;
        }
        $PALETTE = json_decode($template_user->css_properties, true);
    }
    
    protected function _initPlaceholder() {
        $this->bootstrap('session');

        $session = new Zend_Session_Namespace();
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

        // Set region for messages
        if (!isset($session->messages)) {
            $session->messages = new Yachay_Regions_Message();
        }
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
