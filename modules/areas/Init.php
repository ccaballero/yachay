<?php

class Areas_Init extends Yeah_Init
{
    public $check = array ('area', 'area_subject', 'area_resource');
    public $install = 'areas';

    public $routes = array (
        'areas_area_edit'                        => array('areas/:area/edit',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'area',
                                                        'action'     => 'edit',
                                                    )),
        'areas_area_delete'                      => array('areas/:area/delete',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'area',
                                                        'action'     => 'delete',
                                                    )),
        'areas_area_view'                        => array('areas/:area',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'area',
                                                        'action'     => 'view',
                                                    )),
        'areas_manager'                          => array('areas/manager',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'areas_new'                              => array('areas/new',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'areas_list'                             => array('areas',
                                                    array(
                                                        'module'     => 'areas',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
