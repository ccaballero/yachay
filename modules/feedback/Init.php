<?php

class modules_feedback_Init extends Yeah_Init
{
    public $check = array ('feedback');
    public $install = 'feedback';

    public $routes = array (
        'feedback_entry_edit'                    => array('feedback/:entry/edit',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'edit',
                                                    )),
        'feedback_entry_resolv'                  => array('feedback/:entry/resolv',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'resolv',
                                                    )),
        'feedback_entry_unresolv'                => array('feedback/:entry/unresolv',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'unresolv',
                                                    )),
        'feedback_entry_mark'                    => array('feedback/:entry/mark',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'mark',
                                                    )),
        'feedback_entry_unmark'                  => array('feedback/:entry/unmark',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'unmark',
                                                    )),
        'feedback_entry_delete'                  => array('feedback/:entry/delete',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'delete',
                                                    )),
        'feedback_entry_drop'                    => array('feedback/:entry/drop',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'drop',
                                                    )),
        'feedback_entry_view'                    => array('feedback/:entry',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'entry',
                                                        'action'     => 'view',
                                                    )),
        'feedback_new'                           => array('feedback/new',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'feedback_manager'                       => array('feedback/manager',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'feedback_list'                          => array('feedback',
                                                    array(
                                                        'module'     => 'feedback',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
