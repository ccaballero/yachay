<?php

class Analytics_Init extends Yachay_Init
{
    public $routes = array (
        'analytics_view'                         => array('analytics/:page',
                                                    array(
                                                        'module'     => 'analytics',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                        'page'       => 'users',
                                                    )),
    );
}
