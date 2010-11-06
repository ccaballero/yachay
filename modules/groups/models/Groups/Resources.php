<?php

class Groups_Resources extends Yeah_Model_Table
{
    protected $_name            = 'group_resource';
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'Groups',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
