<?php

class modules_areas_models_Areas_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'area_resource';
    protected $_referenceMap    = array(
        'Area'                  => array(
            'columns'           => array('area'),
            'refTableClass'     => 'modules_areas_models_Areas',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
