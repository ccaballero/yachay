<?php

class Teams_Init extends Yeah_Init
{
    public $check = array ('team', 'team_user', 'team_resource');
    public $install = 'teams';

    public $routes = array (
        'teams_team_edit'                        => array('subjects/:subject/groups/:group/teams/:team/edit',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'team',
                                                        'action'     => 'edit',
                                                    )),
        'teams_team_lock'                        => array('subjects/:subject/groups/:group/teams/:team/lock',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'team',
                                                        'action'     => 'lock',
                                                    )),
        'teams_team_unlock'                      => array('subjects/:subject/groups/:group/teams/:team/unlock',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'team',
                                                        'action'     => 'unlock',
                                                    )),
        'teams_team_delete'                      => array('subjects/:subject/groups/:group/teams/:team/delete',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'team',
                                                        'action'     => 'delete',
                                                    )),
        'teams_team_member_delete'               => array('subjects/:subject/groups/:group/teams/:team/:user/delete',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'member',
                                                        'action'     => 'delete',
                                                    )),
        'teams_team_view'                        => array('subjects/:subject/groups/:group/teams/:team',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'team',
                                                        'action'     => 'view',
                                                    )),
        'teams_manager'                          => array('subjects/:subject/groups/:group/teams/manager',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'teams_assign'                           => array('subjects/:subject/groups/:group/teams/assign',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'assign',
                                                        'action'     => 'index',
                                                    )),
        'teams_new'                              => array('subjects/:subject/groups/:group/teams/new',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'teams_lock'                             => array('subjects/:subject/groups/:group/teams/lock',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'teams_unlock'                           => array('subjects/:subject/groups/:group/teams/unlock',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'teams_delete'                           => array('subjects/:subject/groups/:group/teams/delete',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'manager',
                                                        'action'     => 'delete',
                                                    )),
        'teams_list'                             => array('subjects/:subject/groups/:group/teams',
                                                    array(
                                                        'module'     => 'teams',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
