<?php

class modules_regions_Init extends Yeah_Init
{
    public $routes = array (
        'regions_manager'                        => array('regions/manager',
                                                    array(
                                                        'module'     => 'regions',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'regions_list'                           => array('regions',
                                                    array(
                                                        'module'     => 'regions',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
