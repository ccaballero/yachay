<?php

class modules_communities_models_Communities_Petitions extends Zend_Db_Table_Abstract
{
    protected $_name            = 'community_petition';
    protected $_referenceMap    = array(
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'modules_communities_models_Communities',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
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
