<?php

class Users_Init extends Yeah_Init
{
    public $check = array ('user', 'user_resource');
    public $install = 'users';

    public $routes = array (
        'users_user_edit'                        => array('users/:user/edit',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'user',
                                                        'action'     => 'edit',
                                                    )),
        'users_user_lock'                        => array('users/:user/lock',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'user',
                                                        'action'     => 'lock',
                                                    )),
        'users_user_unlock'                      => array('users/:user/unlock',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'user',
                                                        'action'     => 'unlock',
                                                    )),
        'users_user_delete'                      => array('users/:user/delete',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'user',
                                                        'action'     => 'delete',
                                                    )),
        'users_user_view'                        => array('users/:user',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'user',
                                                        'action'     => 'view',
                                                    )),
        'users_manager'                          => array('users/manager',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'users_new'                              => array('users/new',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'users_lock'                             => array('users/lock',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'users_unlock'                           => array('users/unlock',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'users_delete'                           => array('users/delete',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'delete',
                                                    )),
        'users_import'                           => array('users/import',
                                                    array (
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'import',
                                                    )),
        'users_export'                           => array('users/export',
                                                    array (
                                                        'module'     => 'users',
                                                        'controller' => 'manager',
                                                        'action'     => 'export',
                                                    )),
        'users_list'                             => array('users',
                                                    array(
                                                        'module'     => 'users',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
