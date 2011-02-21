<?php

class Careers_Init extends Yeah_Init
{
    public $check = array ('career', 'career_subject', 'career_resource');
    public $install = 'careers';

    public $routes = array (
        'careers_career_edit'                    => array('careers/:career/edit',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'career',
                                                        'action'     => 'edit',
                                                    )),
        'careers_career_delete'                  => array('careers/:career/delete',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'career',
                                                        'action'     => 'delete',
                                                    )),
        'careers_career_view'                    => array('careers/:career',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'career',
                                                        'action'     => 'view',
                                                    )),
        'careers_manager'                        => array('careers/manager',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'careers_new'                            => array('careers/new',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'careers_list'                           => array('careers',
                                                    array(
                                                        'module'     => 'careers',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
