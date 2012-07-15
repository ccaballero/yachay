<?php

class Communities_Resources extends Yachay_Db_Table
{
    protected $_name            = 'community_resource';
    protected $_referenceMap    = array(
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'Communities',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
