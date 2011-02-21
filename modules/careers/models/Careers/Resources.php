<?php

class Careers_Resources extends Yeah_Model_Table
{
    protected $_name            = 'career_resource';
    protected $_referenceMap    = array(
        'Career'                => array(
            'columns'           => array('career'),
            'refTableClass'     => 'Careers',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
