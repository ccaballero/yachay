<?php

class modules_groups_models_Groups_Users extends Zend_Db_Table_Abstract
{
    protected $_name            = 'group_user';
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'modules_groups_models_Groups',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByGroupAndUser($group, $user) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('user = ?', $user));
    }
}
