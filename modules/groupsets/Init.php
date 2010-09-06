<?php

class modules_groupsets_Init extends Yeah_Init
{
    public $check = array ('groupset', 'groupset_group');
    public $install = 'groupsets';

    public $routes = array (
        'groupsets_groupset_edit'                => array('groupsets/:groupset/edit',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'groupset',
                                                        'action'     => 'edit',
                                                    )),
        'groupsets_groupset_delete'              => array('groupsets/:groupset/delete',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'groupset',
                                                        'action'     => 'delete',
                                                    )),
        'groupsets_groupset_view'                => array('groupsets/:groupset',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'groupset',
                                                        'action'     => 'view',
                                                    )),
        'groupsets_manager'                      => array('groupsets/manager',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'groupsets_new'                          => array('groupsets/new',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'groupsets_delete'                       => array('groupsets/delete',
                                                    array(
                                                        'module'     => 'groupsets',
                                                        'controller' => 'manager',
                                                        'action'     => 'delete',
                                                    )),
    );
}
