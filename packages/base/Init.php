<?php

class Base_Init extends Yachay_Init
{
    public $routes = array (
        'base'                             => array('',
                                                   array(
                                                       'module'     => 'base',
                                                       'controller' => 'index',
                                                       'action'     => 'index',
                                                   )),
        'base_visitor'                     => array('visitor',
                                                   array(
                                                       'module'     => 'base',
                                                       'controller' => 'index',
                                                       'action'     => 'visitor',
                                                   )),
        'base_user'                        => array('user',
                                                   array(
                                                       'module'     => 'base',
                                                       'controller' => 'index',
                                                       'action'     => 'user',
                                                   )),
        'base_space_selector'              => array('filter_spaces',
                                                   array(
                                                       'module'      => 'base',
                                                       'controller'  => 'index',
                                                       'action'      => 'spaces',
                                                   )),
        'base_confirm'                     => array('confirm',
                                                   array(
                                                       'module'      => 'base',
                                                       'controller'  => 'index',
                                                       'action'      => 'confirm',
                                                   )),
        'base_development'                 => array('development',
                                                   array(
                                                       'module'      => 'base',
                                                       'controller'  => 'static',
                                                       'action'      => 'development',
                                                   )),
        'base_terms'                       => array('terms',
                                                   array(
                                                       'module'      => 'base',
                                                       'controller'  => 'static',
                                                       'action'      => 'terms',
                                                   )),
        'base_privacy'                     => array('privacy',
                                                   array(
                                                       'module'      => 'base',
                                                       'controller'  => 'static',
                                                       'action'      => 'privacy',
                                                   )),
    );
}
