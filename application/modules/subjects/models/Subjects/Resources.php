<?php

class Subjects_Resources extends Yachay_Models_Table
{
    protected $_name            = 'subject_resource';
    protected $_referenceMap    = array(
        'Subject'               => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'Subjects',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
