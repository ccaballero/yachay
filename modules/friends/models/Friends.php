<?php

class modules_friends_models_Friends extends Zend_Db_Table_Abstract
{
    protected $_name            = 'friend';
    protected $_rowClass        = 'modules_friends_models_Friends_Friend';
    protected $_dependentTables = array();
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => 'user',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
        'Friend'                => array(
            'columns'           => 'friend',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
    );

    // Especial method in existence
    public function hasContact($user, $friend) {
        $row = $this->fetchRow($this->select()->where('user = ?', $user)->where('friend = ?', $friend));
        return !empty($row);
    }

    public function getContact($user, $friend) {
        return $this->fetchRow($this->select()->where('user = ?', $user)->where('friend = ?', $friend));
    }
    
    // Selects in table
    public function selectByUser($user) {
        return $this->fetchAll($this->select()->where('user = ?', $user)->order('tsregister ASC'));
    }

    public function selectByFriend($friend) {
        return $this->fetchAll($this->select()->where('friend = ?', $friend)->order('tsregister DESC'));
    }
}
