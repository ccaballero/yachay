<?php

class Areas_Resources extends Yachay_Db_Table
{
    protected $_name            = 'area_resource';
    protected $_referenceMap    = array(
        'Area'                  => array(
            'columns'           => array('area'),
            'refTableClass'     => 'Areas',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
