<?php

class modules_tags_Init extends Yeah_Init
{
    public $check = array ('tag', 'tag_resource');
    public $install = 'tags';

    public $routes = array (
        'tags_list'                              => array('tags',
                                                    array(
                                                        'module'     => 'tags',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
