<?php

class Groups_Init extends Yeah_Init
{
    public $check = array ('group', 'group_user', 'group_resource');
    public $install = 'groups';

    public $routes = array (
        'groups_group_calification'              => array('subjects/:subject/groups/:group/calification',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'calification',
                                                    )),
        'groups_group_edit'                      => array('subjects/:subject/groups/:group/edit',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'edit',
                                                    )),
        'groups_group_lock'                      => array('subjects/:subject/groups/:group/lock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'lock',
                                                    )),
        'groups_group_unlock'                    => array('subjects/:subject/groups/:group/unlock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'unlock',
                                                    )),
        'groups_group_delete'                    => array('subjects/:subject/groups/:group/delete',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'delete',
                                                    )),
        'groups_group_assign_member_lock'        => array('subjects/:subject/groups/:group/assign/:user/lock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'member',
                                                        'action'     => 'lock',
                                                    )),
        'groups_group_assign_member_unlock'      => array('subjects/:subject/groups/:group/assign/:user/unlock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'member',
                                                        'action'     => 'unlock',
                                                    )),
        'groups_group_assign_member_delete'      => array('subjects/:subject/groups/:group/assign/:user/delete',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'member',
                                                        'action'     => 'delete',
                                                    )),
        'groups_group_assign_new'                => array('subjects/:subject/groups/:group/assign/new',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'new',
                                                    )),
        'groups_group_assign_lock'               => array('subjects/:subject/groups/:group/assign/lock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'lock',
                                                    )),
        'groups_group_assign_unlock'             => array('subjects/:subject/groups/:group/assign/unlock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'unlock',
                                                    )),
        'groups_group_assign_delete'             => array('subjects/:subject/groups/:group/assign/delete',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'delete',
                                                    )),
        'groups_group_assign_import'             => array('subjects/:subject/groups/:group/assign/import',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'import',
                                                    )),
        'groups_group_assign_export'             => array('subjects/:subject/groups/:group/assign/export',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'export',
                                                    )),
        'groups_group_assign'                    => array('subjects/:subject/groups/:group/assign',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'assign',
                                                        'action'     => 'index',
                                                    )),
        'groups_group_view'                      => array('subjects/:subject/groups/:group',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'group',
                                                        'action'     => 'view',
                                                    )),
        'groups_manager'                         => array('subjects/:subject/groups/manager',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'groups_new'                             => array('subjects/:subject/groups/new',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'groups_lock'                            => array('subjects/:subject/groups/lock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'groups_unlock'                          => array('subjects/:subject/groups/unlock',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'groups_delete'                          => array('subjects/:subject/groups/delete',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'manager',
                                                        'action'     => 'delete',
                                                    )),
        'groups_list'                            => array('groups',
                                                    array(
                                                        'module'     => 'groups',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
