<?php

class Settings_Init extends Yachay_Init
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
