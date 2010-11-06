<?php

class Teams_Resources extends Yeah_Model_Table
{
    protected $_name            = 'team_resource';
    protected $_referenceMap    = array(
        'Team'                  => array(
            'columns'           => array('team'),
            'refTableClass'     => 'Teams',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
