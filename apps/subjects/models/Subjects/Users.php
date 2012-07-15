<?php

class Subjects_Users extends Yachay_Db_Table
{
    protected $_name            = 'subject_user';
    protected $_referenceMap    = array(
        'Subject'              => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'Subjects',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findBySubjectAndUser($subject, $user) {
        return $this->fetchRow($this->select()->where('subject = ?', $subject)->where('user = ?', $user));
    }
}
