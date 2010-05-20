<?php

class modules_groupsets_models_Groupsets_Groups extends Zend_Db_Table_Abstract
{
    protected $_name            = 'groupset_group';
    protected $_referenceMap    = array(
        'Groupset'              => array(
            'columns'           => array('groupset'),
            'refTableClass'     => 'modules_groupsets_models_Groupsets',
            'refColumns'        => array('ident'),
        ),
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'modules_groups_models_Groups',
            'refColumns'        => array('ident'),
        ),
    );
}
