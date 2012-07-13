<?php

class Pages_Init extends Yachay_Init
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
