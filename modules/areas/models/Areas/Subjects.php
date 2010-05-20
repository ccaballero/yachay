<?php

class modules_areas_models_Areas_Subjects extends Zend_Db_Table_Abstract
{
    protected $_name            = 'area_subject';
    protected $_referenceMap    = array(
        'Area'                  => array(
            'columns'           => array('area'),
            'refTableClass'     => 'modules_areas_models_Areas',
            'refColumns'        => array('ident'),
        ),
        'Subject'              => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'modules_subjects_models_Subjects',
            'refColumns'        => array('ident'),
        ),
    );
}
