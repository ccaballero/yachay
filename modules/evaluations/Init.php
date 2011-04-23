<?php

class Evaluations_Init extends Yeah_Init
{
    public $check = array ('evaluation', 'evaluation_test', 'evaluation_test_value');
    public $install = 'evaluations';

    public $routes = array (
        'evaluations_evaluation_test_value_delete' => array('evaluations/:evaluation/:test/:value/delete',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'test',
                                                        'action'     => 'value',
                                                    )),
        'evaluations_evaluation_test_delete'     => array('evaluations/:evaluation/:test/delete',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'test',
                                                        'action'     => 'delete',
                                                    )),
        'evaluations_evaluation_test_config'     => array('evaluations/:evaluation/:test',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'test',
                                                        'action'     => 'config',
                                                    )),
        'evaluations_evaluation_edit'            => array('evaluations/:evaluation/edit',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'evaluation',
                                                        'action'     => 'edit',
                                                    )),
       'evaluations_evaluation_delete'           => array('evaluations/:evaluation/delete',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'evaluation',
                                                        'action'     => 'delete',
                                                    )),
       'evaluations_evaluation_test_add'         => array('evaluations/:evaluation/add',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'test',
                                                        'action'     => 'add',
                                                    )),
        'evaluations_evaluation_view'            => array('evaluations/:evaluation',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'evaluation',
                                                        'action'     => 'view',
                                                    )),
       'evaluations_sandbox'                     => array('evaluations/sandbox',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'manager',
                                                        'action'     => 'sandbox',
                                                    )),
        'evaluations_new'                        => array('evaluations/new',
                                                    array(
                                                        'module'     => 'evaluations',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
