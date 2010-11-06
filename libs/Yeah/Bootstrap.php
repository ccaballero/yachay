<?php

// Basic elements
global $CONFIG;
global $PAGE;
global $USER;
global $TEMPLATE;

// Database connector
global $DB;

// Logger element
global $LOG;

// Regions definition
global $TITLE;
global $ICON;
global $BANNER;
global $TOOLBAR;
global $SEARCH;
global $MENUBAR;
global $CONTENT;
global $BREADCRUMB;
global $WIDGETS;
global $FOOTER;

class Yeah_Bootstrap
{
    public function initialize() {
        error_reporting(E_ALL | E_STRICT);
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'libs' . PATH_SEPARATOR . 'modules');

        // PHP's settings for encoding
        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');

        require_once 'Utils.php';

        // Settings for classes autoloading
        require_once 'Zend/Loader/Autoloader.php';
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Zend_');
        $loader->registerNamespace('Yeah_');
        $loader->registerNamespace('File_');
        $loader->registerNamespace('Xcel_');
        $loader->pushAutoloader(new Yeah_Loader());

        // Initialization and recover of the session
        Zend_Session::start();
        $session = new Zend_Session_Namespace();

        // Set of fundamental element
        global $CONFIG;
        $CONFIG = new Yeah_Settings_Config();

        // Set for debugging level
        ini_set('display_startup_errors', $CONFIG->startup_errors);
        ini_set('display_errors', $CONFIG->display_errors);

        // Set connector database
        global $DB;
        $DATABASE = new Yeah_Settings_Database();
        $DB = Zend_Db::factory(
            $DATABASE->type, 
            array(
                'host'     => $DATABASE->hostname,
                'username' => $DATABASE->username,
                'password' => $DATABASE->password,
                'dbname'   => $DATABASE->database,
            )
        );

        // Set for user information, if exists
        global $USER;
        if (isset($session->user)) {
            $USER = $session->user;
        } else {
            $USER = new Users_Visitor();
        }

        // Set for context information
        if (!isset($session->context)) {
            $session->context = new Yeah_Settings_Context();
        }

        // Set of history of navigation
        if (!isset($session->history)) {
            $session->history = new Yeah_Settings_History();
        }

        // Set of theme
        global $TEMPLATE;
        $model_templates = new Templates();
        $template = $model_templates->findByLabel($CONFIG->template);

        $TEMPLATE = json_decode($template->properties, false);
        $TEMPLATE->name = $CONFIG->template;
        $TEMPLATE->doctype = $template->doctype;
        $TEMPLATE->htmlbase = $CONFIG->wwwroot . 'templates/' . $TEMPLATE->name . '/';

        // Set for localization
        setlocale(LC_CTYPE, $CONFIG->locale);
        Zend_Locale::setDefault($CONFIG->locale);
        
        // Setting logging system
        date_default_timezone_set($CONFIG->time_zone);
        
        global $LOG;
        $LOG = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream($CONFIG->dirroot . 'yeah.log', 'a');
        $LOG->addWriter($writer);

        // Set of web regions
        global $TITLE;
        $TITLE = new Yeah_Regions_Title();
        global $ICON;
        $ICON = new Yeah_Regions_Icon();
        global $TOOLBAR;
        $TOOLBAR = new Yeah_Regions_Toolbar();
        global $SEARCH;
        $SEARCH = new Yeah_Regions_Search();
        global $MENUBAR;
        $MENUBAR = new Yeah_Regions_Menubar();
        global $BREADCRUMB;
        $BREADCRUMB = new Yeah_Regions_Breadcrumb();
        global $FOOTER;
        $FOOTER = new Yeah_Regions_Footer();
        // Set of web widgets
        global $WIDGETS;
        $WIDGETS = array(1=>'',2=>'',3=>'',4=>'');

        // Set region for messages
        if (!isset($session->messages)) {
            $session->messages = new Yeah_Regions_Message();
        }
    }

    public function run() {
        global $CONFIG;
        global $TEMPLATE;

        $front = Zend_Controller_Front::getInstance();
        $front->throwExceptions(true)
              ->addModuleDirectory($CONFIG->dirroot . 'modules/')
              ->setDefaultModule('frontpage')
              ->returnResponse(true);

        // Routes join
        $model_modules = new Modules();
        $modules = $model_modules->selectByStatus('active');
        foreach ($modules as $module) {
            $path = $CONFIG->dirroot . 'modules/' . $module->url;
            if (is_dir($path)) {
                if (file_exists("$path/Init.php")) {
                    include "$path/Init.php";
                    $class = ucfirst(strtolower($module->url)) . '_Init';
                    $obj = new $class();
                    $obj->setRoutes($front->getRouter());
                    if (!Yeah_Adapter::check($obj->check)) {
                        Yeah_Adapter::install($obj->install);
                    }
                }
            }
        }

        // Change the suffix of phtml to php
        $renderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $renderer->setViewSuffix('php');
        Zend_Controller_Action_HelperBroker::addHelper($renderer);

        $layoutoptions = array(
            'layout'     => $TEMPLATE->name,
            'layoutPath' => $CONFIG->dirroot . 'templates/',
            'viewSuffix' => 'php',
        );

        include_once $CONFIG->dirroot . 'libs/Yeah/Action.php';
        Zend_Layout::startMvc($layoutoptions);

        try {
            $response = $front->dispatch();
            $response->sendResponse();
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
