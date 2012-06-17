<?php

class Packages_Init extends Yachay_Init
{
    public $check = array ('package');
    public $install = 'packages';

    public $routes = array (
        'packages_package_lock'                    => array('packages/:mod/lock',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'package',
                                                        'action'     => 'lock',
                                                    )),
        'packages_package_unlock'                  => array('packages/:mod/unlock',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'package',
                                                        'action'     => 'unlock',
                                                    )),
        'packages_package_view'                    => array('packages/:mod',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'package',
                                                        'action'     => 'view',
                                                    )),
        'packages_manager'                        => array('packages/manager',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'packages_new'                            => array('packages/new',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'packages_lock'                           => array('packages/lock',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'packages_unlock'                         => array('packages/unlock',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'packages_list'                           => array('packages',
                                                    array(
                                                        'package'     => 'packages',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
