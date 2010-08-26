<?php

class modules_communities_Init extends Yeah_Init
{
    public $check = array ('community', 'community_user', 'community_petition', 'community_resource');
    public $install = 'communities';

    public $routes = array (
        'communities_community_edit'                => array('communities/:community/edit',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'edit',
                                                    )),
        'communities_community_delete'              => array('communities/:community/delete',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'delete',
                                                    )),
        'communities_community_view'             => array('communities/:community',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'view',
                                                    )),
        'communities_manager'                    => array('communities/manager',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'communities_new'                       => array('communities/new',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'communities_list'                       => array('communities',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
