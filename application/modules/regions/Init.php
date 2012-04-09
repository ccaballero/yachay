<?php

class Regions_Init extends Yachay_Init
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
