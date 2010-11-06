<?php

class Settings_Init extends Yeah_Init
{
    public $routes = array (
        'settings'                               => array('settings/:user',
                                                    array(
                                                        'module'     => 'settings',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
