<?php

class modules_pages_Init extends Yeah_Init
{
    public $routes = array (
        'pages_manager'                          => array('pages/manager',
                                                    array(
                                                        'module'     => 'pages',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'pages_list'                             => array('pages',
                                                    array(
                                                        'module'     => 'pages',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
