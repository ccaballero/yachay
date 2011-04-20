<?php

class Links_Init extends Yeah_Init
{
    public $check = array ('link');
    public $install = 'links';

    public $routes = array (
        'links_link_edit'                        => array('links/:link/edit',
                                                    array(
                                                        'module'     => 'links',
                                                        'controller' => 'link',
                                                        'action'     => 'edit',
                                                    )),
        'links_link_delete'                      => array('links/:link/delete',
                                                    array(
                                                        'module'     => 'links',
                                                        'controller' => 'link',
                                                        'action'     => 'delete',
                                                    )),
        'links_link_drop'                        => array('links/:link/drop',
                                                    array(
                                                        'module'     => 'links',
                                                        'controller' => 'link',
                                                        'action'     => 'drop',
                                                    )),
        'links_link_view'                        => array('links/:link',
                                                    array(
                                                        'module'     => 'links',
                                                        'controller' => 'link',
                                                        'action'     => 'view',
                                                    )),
        'links_new'                              => array('links/new',
                                                    array(
                                                        'module'     => 'links',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
