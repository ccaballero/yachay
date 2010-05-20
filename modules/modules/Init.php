<?php

class modules_modules_Init extends Yeah_Init
{
    public $check = array ('module');
    public $install = 'modules';

    public $routes = array (
        'modules_module_lock'                    => array('modules/:mod/lock',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'module',
                                                        'action'     => 'lock',
                                                    )),
        'modules_module_unlock'                  => array('modules/:mod/unlock',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'module',
                                                        'action'     => 'unlock',
                                                    )),
        'modules_module_view'                    => array('modules/:mod',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'module',
                                                        'action'     => 'view',
                                                    )),
        'modules_manager'                        => array('modules/manager',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'modules_new'                            => array('modules/new',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'modules_lock'                           => array('modules/lock',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'modules_unlock'                         => array('modules/unlock',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'modules_list'                           => array('modules',
                                                    array(
                                                        'module'     => 'modules',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
