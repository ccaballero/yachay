<?php

class modules_roles_Init extends Yeah_Init
{
    public $check = array ('role', 'role_privilege');
    public $install = 'roles';

    public $routes = array (
        'roles_role_edit'                        => array('roles/:role/edit',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'role',
                                                        'action'     => 'edit',
                                                    )),
        'roles_role_delete'                      => array('roles/:role/delete',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'role',
                                                        'action'     => 'delete',
                                                    )),
        'roles_role_view'                        => array('roles/:role',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'role',
                                                        'action'     => 'view',
                                                    )),
        'roles_assign'                           => array('roles/assign',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'assign',
                                                        'action'     => 'index',
                                                    )),
        'roles_manager'                          => array('roles/manager',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'roles_new'                              => array('roles/new',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'roles_list'                             => array('roles',
                                                    array(
                                                        'module'     => 'roles',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
