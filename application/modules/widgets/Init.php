<?php

class Widgets_Init extends Yachay_Init
{
    public $routes = array (
        'widgets_manager'                        => array('widgets/manager',
                                                    array(
                                                        'module'     => 'widgets',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'widgets_list'                           => array('widgets',
                                                    array(
                                                        'module'     => 'widgets',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
