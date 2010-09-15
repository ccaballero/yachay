<?php

class modules_friends_Init extends Yeah_Init
{
    public $check = array ('friend');
    public $install = 'friends';

    public $routes = array (
        'friends_add'                            => array('friends/:user/add',
        											array(
        											    'module'     => 'friends',
        											    'controller' => 'friend',
        											    'action'     => 'add',
        											)),
        'friends_delete'	                     => array('friends/:user/delete',
        											array(
        											    'module'     => 'friends',
        											    'controller' => 'friend',
        											    'action'     => 'delete',
        											)),
        'friends_followers'                      => array('friends/followers',
                                                    array(
                                                        'module'     => 'friends',
                                                        'controller' => 'index',
                                                        'action'     => 'followers',
                                                    )),
        'friends_followings'                      => array('friends/followings',
                                                    array(
                                                        'module'     => 'friends',
                                                        'controller' => 'index',
                                                        'action'     => 'followings',
                                                    )),
        'friends_friends'                        => array('friends',
                                                    array(
                                                        'module'     => 'friends',
                                                        'controller' => 'index',
                                                        'action'     => 'friends',
                                                    )),
    );
}
