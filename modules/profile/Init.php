<?php

class modules_profile_Init extends Yeah_Init
{
    public $routes = array (
        'profile_view'                           => array('profile/:user',
                                                    array(
                                                        'module'     => 'profile',
                                                        'controller' => 'index',
                                                        'action'     => 'view',
                                                    )),
        'profile_edit'                           => array('profile/:user/edit',
                                                    array(
                                                        'module'     => 'profile',
                                                        'controller' => 'index',
                                                        'action'     => 'edit',
                                                    )),
    );
}
