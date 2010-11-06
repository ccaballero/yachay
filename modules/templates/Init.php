<?php

class Templates_Init extends Yeah_Init
{
    public $check = array ('template');
    public $install = 'templates';

    public $routes = array (
        'templates_list'                         => array('templates',
                                                    array(
                                                        'module'     => 'templates',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
