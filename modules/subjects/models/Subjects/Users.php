<?php

class modules_subjects_models_Subjects_Users extends Zend_Db_Table_Abstract
{
    protected $_name            = 'subject_user';
    protected $_referenceMap    = array(
        'Subject'              => array(
            'columns'           => array('subject'),
            'refTableClass'     => 'modules_subjects_models_Subjects',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findBySubjectAndUser($subject, $user) {
        return $this->fetchRow($this->select()->where('subject = ?', $subject)->where('user = ?', $user));
    }
}
