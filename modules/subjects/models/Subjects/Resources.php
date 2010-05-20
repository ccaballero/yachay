<?php

class modules_subjects_models_Subjects_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'subject_resource';
    protected $_referenceMap    = array(
        'Subject'               => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'modules_subjects_models_Subjects',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
