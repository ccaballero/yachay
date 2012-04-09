<?php

class Profile_Init extends Yachay_Init
{
    public $routes = array (
        'profile_view'                           => array('profile',
                                                    array(
                                                        'module'     => 'profile',
                                                        'controller' => 'index',
                                                        'action'     => 'view',
                                                    )),
        'profile_edit'                           => array('profile/edit',
                                                    array(
                                                        'module'     => 'profile',
                                                        'controller' => 'index',
                                                        'action'     => 'edit',
                                                    )),
    );
}
