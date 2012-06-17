<?php

class Careers_Subjects extends Yachay_Models_Table
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
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->delete('career_subject', 'subject = ' . $subject);
    }
}
