<?php

class Tags_Init extends Yeah_Init
{
    public $check = array ('tag', 'tag_resource');
    public $install = 'tags';

    public $routes = array (
        'tags_tag_delete'                        => array('tags/:tag/delete',
                                                    array(
                                                        'module'     => 'tags',
                                                        'controller' => 'tag',
                                                        'action'     => 'delete',
                                                    )),
        'tags_tag_view'                          => array('tags/:tag',
                                                    array(
                                                        'module'     => 'tags',
                                                        'controller' => 'tag',
                                                        'action'     => 'view',
                                                    )),
        'tags_manager'                           => array('tags/manager',
                                                    array(
                                                        'module'     => 'tags',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'tags_list'                              => array('tags',
                                                    array(
                                                        'module'     => 'tags',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
