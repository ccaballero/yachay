<?php

class Communities_Users extends Yachay_Db_Table
{
    protected $_name            = 'community_user';
    protected $_referenceMap    = array(
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'Communities',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByCommunityAndUser($community, $user) {
        return $this->fetchRow($this->select()->where('community = ?', $community)->where('user = ?', $user));
    }

    public function deleteUsersInCommunity($community) {
        $this->delete('`community` = ' . $community);
    }
}
