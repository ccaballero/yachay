<?php

class Login_Init extends Yeah_Init
{
    public $routes = array (
        'login_in'                               => array('login',
                                                    array(
                                                        'module'     => 'login',
                                                        'controller' => 'index',
                                                        'action'     => 'in',
                                                    )),
        'login_out'                              => array('logout',
                                                    array(
                                                        'module'     => 'login',
                                                        'controller' => 'index',
                                                        'action'     => 'out',
                                                    )),
        'login_forgot'                           => array('forgot',
                                                    array(
                                                        'module'     => 'login',
                                                        'controller' => 'forgot',
                                                        'action'     => 'index',
                                                    )),
    );
}
