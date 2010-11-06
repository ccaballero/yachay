<?php

class Califications_Init extends Yeah_Init
{
    public $check = array ('calification');
    public $install = 'califications';

    public $routes = array (
        'califications_export'                   => array('subjects/:subject/groups/:group/califications/export',
                                                    array(
                                                        'module'     => 'califications',
                                                        'controller' => 'manager',
                                                        'action'     => 'export',
                                                    )),
        'califications_import'                   => array('subjects/:subject/groups/:group/califications/import',
                                                    array(
                                                        'module'     => 'califications',
                                                        'controller' => 'manager',
                                                        'action'     => 'import',
                                                    )),
        'califications_manager'                  => array('subjects/:subject/groups/:group/califications',
                                                    array(
                                                        'module'     => 'califications',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'califications_view'                     => array('califications',
                                                    array(
                                                        'module'     => 'califications',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
