<?php

class modules_notes_Init extends Yeah_Init
{
    public $check = array ('note');
    public $install = 'notes';

    public $routes = array (
        'notes_note_edit'                        => array('notes/:note/edit',
                                                    array(
                                                        'module'     => 'notes',
                                                        'controller' => 'note',
                                                        'action'     => 'edit',
                                                    )),
        'notes_note_delete'                      => array('notes/:note/delete',
                                                    array(
                                                        'module'     => 'notes',
                                                        'controller' => 'note',
                                                        'action'     => 'delete',
                                                    )),
        'notes_note_view'                        => array('notes/:note',
                                                    array(
                                                        'module'     => 'notes',
                                                        'controller' => 'note',
                                                        'action'     => 'view',
                                                    )),
        'notes_new'                              => array('notes/new',
                                                    array(
                                                        'module'     => 'notes',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
