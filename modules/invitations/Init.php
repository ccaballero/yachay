<?php

class Invitations_Init extends Yeah_Init
{
    public $check = array ('invitation');
    public $install = 'invitations';

    public $routes = array (
       'invitations_invitation_delete'           => array('invitations/:invitation/delete',
                                                    array(
                                                        'module'     => 'invitations',
                                                        'controller' => 'invitation',
                                                        'action'     => 'delete',
                                                    )),
       'invitations_invitation_proceed'          => array('invitations/:code',
                                                    array(
                                                        'module'     => 'invitations',
                                                        'controller' => 'invitation',
                                                        'action'     => 'proceed',
                                                    )),
        'invitations_manager'                    => array('invitations/manager',
                                                    array(
                                                        'module'     => 'invitations',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'invitations_new'                        => array('invitations/new',
                                                    array(
                                                        'module'     => 'invitations',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
    );
}
