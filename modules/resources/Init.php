<?php

class Resources_Init extends Yeah_Init
{
    public $routes = array (
        'resources_list'                         => array('resources',
                                                    array(
                                                        'module'     => 'resources',
                                                        'controller' => 'index',
                                                        'action'     => 'list',
                                                    )),
        'resources_filtered'                     => array('resources/:filter',
                                                    array(
                                                        'module'     => 'resources',
                                                        'controller' => 'index',
                                                        'action'     => 'filtered',
                                                    )),
    );
}
