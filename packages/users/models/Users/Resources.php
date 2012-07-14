<?php

class Users_Resources extends Yachay_Model_Table
{
    protected $_name            = 'user_resource';
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
