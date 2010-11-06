<?php

class Search_Init extends Yeah_Init
{
    public $check = array ('search');
    public $install = 'search';

    public $routes = array (
        'search_list'                            => array('search',
                                                    array(
                                                        'module'     => 'search',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
