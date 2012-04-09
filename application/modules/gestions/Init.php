<?php

class Gestions_Init extends Yachay_Init
{
    public $check = array ('gestion');
    public $install = 'gestions';

    public $routes = array (
        'gestions_gestion_subject'               => array('gestions/:gestion/:subject',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'view',
                                                    )),
        'gestions_gestion_active'                => array('gestions/:gestion/active',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'gestion',
                                                        'action'     => 'active',
                                                    )),
        'gestions_gestion_delete'                => array('gestions/:gestion/delete',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'gestion',
                                                        'action'     => 'delete',
                                                    )),
        'gestions_gestion_view'                  => array('gestions/:gestion',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'gestion',
                                                        'action'     => 'view',
                                                    )),
        'gestions_manager'                       => array('gestions/manager',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'gestions_new'                           => array('gestions/new',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'gestions_list'                          => array('gestions',
                                                    array(
                                                        'module'     => 'gestions',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
