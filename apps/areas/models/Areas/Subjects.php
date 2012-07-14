<?php

class Areas_Subjects extends Yachay_Model_Table
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
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->delete('area_subject', 'subject = ' . $subject);
    }
}
