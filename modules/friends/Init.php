<?php

class modules_friends_Init extends Yeah_Init
{
    public $check = array ('friend');
    public $install = 'friends';

    public $routes = array (
        'friends_add'                            => array('friends/:user/add',
        											array(
        											    'module'     => 'friends',
        											    'controller' => 'index',
        											    'action'     => 'add',
        											)),
        'friends_delete'	                     => array('friends/:user/delete',
        											array(
        											    'module'     => 'friends',
        											    'controller' => 'index',
        											    'action'     => 'delete',
        											)),
        'friends_list'                           => array('friends',
                                                    array(
                                                        'module'     => 'friends',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
