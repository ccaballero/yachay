<?php

class Careers_Subjects extends Yeah_Model_Table
{
    protected $_name            = 'career_subject';
    protected $_referenceMap    = array(
        'Career'                => array(
            'columns'           => array('career'),
            'refTableClass'     => 'Careers',
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
        $DB->delete('career_subject', 'subject = ' . $subject);
    }
}
