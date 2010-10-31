<?php

class modules_subjects_Init extends Yeah_Init
{
    public $check = array ('subject', 'subject_user', 'subject_resource');
    public $install = 'subjects';

    public $routes = array (
        'subjects_subject_edit'                  => array('subjects/:subject/edit',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'edit',
                                                    )),
        'subjects_subject_lock'                  => array('subjects/:subject/lock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'lock',
                                                    )),
        'subjects_subject_unlock'                => array('subjects/:subject/unlock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'unlock',
                                                    )),
        'subjects_subject_delete'                => array('subjects/:subject/delete',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'delete',
                                                    )),
        'subjects_subject_assign_member_lock'    => array('subjects/:subject/assign/:user/lock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'member',
                                                        'action'     => 'lock',
                                                    )),
        'subjects_subject_assign_member_unlock'  => array('subjects/:subject/assign/:user/unlock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'member',
                                                        'action'     => 'unlock',
                                                    )),
        'subjects_subject_assign_member_delete'  => array('subjects/:subject/assign/:user/delete',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'member',
                                                        'action'     => 'delete',
                                                    )),
        'subjects_subject_assign_new'            => array('subjects/:subject/assign/new',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'new',
                                                    )),
        'subjects_subject_assign_lock'           => array('subjects/:subject/assign/lock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'lock',
                                                    )),
        'subjects_subject_assign_unlock'         => array('subjects/:subject/assign/unlock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'unlock',
                                                    )),
        'subjects_subject_assign_delete'         => array('subjects/:subject/assign/delete',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'delete',
                                                    )),
        'subjects_subject_assign_import'         => array('subjects/:subject/assign/import',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'import',
                                                    )),
        'subjects_subject_assign_export'         => array('subjects/:subject/assign/export',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'export',
                                                    )),
        'subjects_subject_assign'                => array('subjects/:subject/assign',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'assign',
                                                        'action'     => 'index',
                                                    )),
        'subjects_subject_view'                  => array('subjects/:subject/',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'subject',
                                                        'action'     => 'view',
                                                    )),
        'subjects_manager'                       => array('subjects/manager',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'subjects_new'                           => array('subjects/new',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'subjects_lock'                          => array('subjects/lock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'lock',
                                                    )),
        'subjects_unlock'                        => array('subjects/unlock',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'unlock',
                                                    )),
        'subjects_delete'                        => array('subjects/delete',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'delete',
                                                    )),
        'subjects_import'                        => array('subjects/import',
                                                    array (
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'import',
                                                    )),
        'subjects_export'                        => array('subjects/export',
                                                    array (
                                                        'module'     => 'subjects',
                                                        'controller' => 'manager',
                                                        'action'     => 'export',
                                                    )),
        'subjects_list'                          => array('subjects',
                                                    array(
                                                        'module'     => 'subjects',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
