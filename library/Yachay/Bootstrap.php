<?php

class Yachay_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
    }

    protected function _initAutoload() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->pushAutoloader(new Yachay_Loader());
    }

    protected function _initRouter() {
        $this->bootstrap(array('config', 'autoload','frontController','db'));

        $config = Zend_Registry::geT('config');

        $ctrl = Zend_Controller_Front::getInstance();
        $router = $ctrl->getRouter();

        // Routes join
        $model_packages = new Db_Packages();
        $packages = $model_packages->selectByStatus('active');
        foreach ($packages as $package) {
            $path = $config->resources->frontController->moduleDirectory . '/' . $package->url;
            if (is_dir($path)) {
                if (file_exists("$path/Init.php")) {
                    include "$path/Init.php";
                    $class = ucfirst(strtolower($package->url)) . '_Init';
                    $obj = new $class();
                    $obj->setRoutes($router);
                }
            }
        }
    }

    protected function _initLocale() {
        $this->bootstrap('config');

        $config = Zend_Registry::get('config');
        // Set for localization
        setlocale(LC_CTYPE, $config->system->locale);
        Zend_Locale::setDefault($config->system->locale);
    }

    protected function _initTimezone() {
        $this->bootstrap('config');

        $config = Zend_Registry::get('config');
        date_default_timezone_set($config->system->timezone);
    }

    protected function _initSession() {
        Zend_Session::start();
    }

    protected function _initUser() {
        $this->bootstrap(array('autoload','session','db'));

        $session = new Zend_Session_Namespace('yachay');
        $user = new Users_Visitor();

        if (isset($session->user)) {
            $ident = $session->user->ident;

            $model_users = new Users();
            $user_logged = $model_users->findByIdent($ident);

            if (!empty($user_logged)) {
                $user = $user_logged;
            }
        }

        Zend_Registry::set('user',$user);
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
        $this->bootstrap(array('config','session'));

        $session = new Zend_Session_Namespace('yachay');
        $config = Zend_Registry::get('config');

        if (!isset($session->currentPage)) {
            $session->currentPage = $config->resources->frontController->baseUrl;
        }
        if (!isset($session->lastPage)) {
            $session->lastPage = $config->resources->frontController->baseUrl;
        }
    }

    protected function _initTemplate() {
        $this->bootstrap(array('autoload','user'));

        $user = Zend_Registry::get('user');
        $config = Zend_Registry::get('config');

        $model_templates = new Templates();
        $template = $model_templates->findByLabel($user->template);

        // Set of theme
        $user_template = new StdClass();
        $user_template->label = $template->label;
        $user_template->parent = $template->parent;
        $user_template->doctype = $template->doctype;
        $user_template->description = $template->description;
        $user_template->css_properties = $template->css_properties;
        $user_template->htmlbase = $config->resources->frontController->baseUrl . '/templates/' . $user_template->label . '/';

        Zend_Registry::set('template', $user_template);

        // Set of color palette
        $model_templates_users = new Templates_Users();
        $template_user = $model_templates_users->findByTemplateAndUser($template->ident, $user->ident);
        if (empty($template_user)) {
            $template_user = $template;
        }
        $palette = json_decode($template_user->css_properties, true);

        Zend_Registry::set('palette', $palette);
    }

    protected function _initPlaceholder() {
        // Set of web regions
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
    }

    protected function _initLayout() {
        $this->bootstrap(array('config', 'template'));

        $config = Zend_Registry::get('config');
        $template = Zend_Registry::get('template');
        Zend_Layout::startMVC(array(
            'layoutPath' => $config->resources->layout->layoutPath,
            'layout'     => $template->label,
            'viewSuffix' => 'php',
        ));
    }
}
