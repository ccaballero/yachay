<?php

class Events_Init extends Yeah_Init
{
    public $check = array ('event');
    public $install = 'events';

    public $routes = array (
        'events_event_edit'                      => array('events/:event/edit',
                                                    array(
                                                        'module'     => 'events',
                                                        'controller' => 'event',
                                                        'action'     => 'edit',
                                                    )),
        'events_event_delete'                    => array('events/:event/delete',
                                                    array(
                                                        'module'     => 'events',
                                                        'controller' => 'event',
                                                        'action'     => 'delete',
                                                    )),
        'events_event_drop'                      => array('events/:event/drop',
                                                    array(
                                                        'module'     => 'events',
                                                        'controller' => 'event',
                                                        'action'     => 'drop',
                                                    )),
        'events_event_view'                      => array('events/:event',
                                                    array(
                                                        'module'     => 'events',
                                                        'controller' => 'event',
                                                        'action'     => 'view',
                                                    )),
        'events_new'                             => array('events/new',
                                                    array(
                                                        'module'     => 'events',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
