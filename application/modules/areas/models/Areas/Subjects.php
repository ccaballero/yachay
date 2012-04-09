<?php

class Areas_Subjects extends Yachay_Models_Table
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

    public function cleanSubjects($subject) {
        global $DB;
        $DB->delete('area_subject', 'subject = ' . $subject);
    }
}
