<?php

class modules_frontpage_Init extends Yeah_Init
{
    public $routes = array (
        'frontpage_visitor'                      => array('visitor',
                                                    array(
                                                        'module'     => 'frontpage',
                                                        'controller' => 'index',
                                                        'action'     => 'visitor',
                                                    )),
        'frontpage_user'                        => array('user',
                                                    array(
                                                        'module'     => 'frontpage',
                                                        'controller' => 'index',
                                                        'action'     => 'user',
                                                    )),
    );
}
