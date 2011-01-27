<?php

class Templates_Init extends Yeah_Init
{
    public $check = array ('template');
    public $install = 'templates';

    public $routes = array (
        'templates_template_switch'              => array('templates/switch/:template',
                                                    array(
                                                        'module'     => 'templates',
                                                        'controller' => 'template',
                                                        'action'     => 'switch',
                                                    )),
        'templates_template_view'                => array('templates/view/:template',
                                                    array(
                                                        'module'     => 'templates',
                                                        'controller' => 'template',
                                                        'action'     => 'view',
                                                    )),
        'templates_css'                          => array('templates/css/properties.css',
                                                    array(
                                                        'module'     => 'templates',
                                                        'controller' => 'manager',
                                                        'action'     => 'css',
                                                    )),
        'templates_list'                         => array('templates',
                                                    array(
                                                        'module'     => 'templates',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
