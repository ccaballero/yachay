<?php

class Frontpage_Init extends Yachay_Init
{
    public $routes = array (
        'frontpage'                             => array('',
                                                   array(
                                                       'module'     => 'frontpage',
                                                       'controller' => 'index',
                                                       'action'     => 'index',
                                                   )),
        'frontpage_visitor'                     => array('visitor',
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
        'frontpage_space_selector'              => array('filter_spaces',
                                                   array(
                                                       'module'      => 'frontpage',
                                                       'controller'  => 'index',
                                                       'action'      => 'spaces',
                                                   )),
        'frontpage_confirm'                     => array('confirm',
                                                   array(
                                                       'module'      => 'frontpage',
                                                       'controller'  => 'index',
                                                       'action'      => 'confirm',
                                                   )),
        'frontpage_development'                 => array('development',
                                                   array(
                                                       'module'      => 'frontpage',
                                                       'controller'  => 'static',
                                                       'action'      => 'development',
                                                   )),
        'frontpage_terms'                       => array('terms',
                                                   array(
                                                       'module'      => 'frontpage',
                                                       'controller'  => 'static',
                                                       'action'      => 'terms',
                                                   )),
        'frontpage_privacy'                     => array('privacy',
                                                   array(
                                                       'module'      => 'frontpage',
                                                       'controller'  => 'static',
                                                       'action'      => 'privacy',
                                                   )),
    );
}
