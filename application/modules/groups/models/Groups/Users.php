<?php

class Groups_Users extends Yachay_Models_Table
{
    protected $_name            = 'group_user';
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'Groups',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByGroupAndUser($group, $user) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('user = ?', $user));
    }
}
