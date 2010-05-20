<?php

class modules_groups_models_Groups_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'group_resource';
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'modules_groups_models_Groups',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
