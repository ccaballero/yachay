<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/..'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/library'),
    get_include_path(),
)));

/* Zend_Config */
require_once 'Zend/Config/Ini.php';

$config = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/application.ini',
    APPLICATION_ENV,
    array('allowModifications' => true)
);

$local = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/local.ini',
    APPLICATION_ENV
);

$config->merge($local);
$config->setReadOnly();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, $config);

$application->bootstrap()
            ->run();
