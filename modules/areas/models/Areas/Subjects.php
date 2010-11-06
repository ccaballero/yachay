<?php

class Areas_Subjects extends Yeah_Model_Table
{
    protected $_name            = 'area_subject';
    protected $_referenceMap    = array(
        'Area'                  => array(
            'columns'           => array('area'),
            'refTableClass'     => 'Areas',
            'refColumns'        => array('ident'),
        ),
        'Subject'              => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'Subjects',
            'refColumns'        => array('ident'),
        ),
    );
}
