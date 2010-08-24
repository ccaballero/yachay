<?php

class modules_communities_Init extends Yeah_Init
{
    public $check = array ('community', 'community_user', 'community_petition', 'community_resource');
    public $install = 'communities';

    public $routes = array ();/*
        'communities_list'                       => array('communities',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );*/
}
