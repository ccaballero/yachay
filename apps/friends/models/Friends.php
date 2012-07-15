<?php

class Friends extends Yachay_Db_Table
{
    protected $_name            = 'friend';
    protected $_rowClass        = 'Friends_Friend';
    protected $_dependentTables = array();
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => 'user',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Friend'                => array(
            'columns'           => 'friend',
            'refTableClass'     => 'Users',
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
    public function selectFriendsByUser($user) {
        return $this->fetchAll($this->select()->where('user = ?', $user)->where('mutual = ?', TRUE)->order('tsregister ASC'));
    }

    public function selectFollowingsByUser($user) {
        return $this->fetchAll($this->select()->where('user = ?', $user)->where('mutual = ?', FALSE)->order('tsregister ASC'));
    }

    public function selectFollowersByUser($user) {
        return $this->fetchAll($this->select()->where('friend = ?', $user)->where('mutual = ?', FALSE)->order('tsregister ASC'));
    }
}
