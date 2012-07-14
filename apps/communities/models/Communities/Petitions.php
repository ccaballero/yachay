<?php

class Communities_Petitions extends Yachay_Model_Table
{
    protected $_name            = 'community_petition';
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

    public function deleteAplicantsInCommunity($community) {
        $this->delete('`community` = ' . $community);
    }
}
