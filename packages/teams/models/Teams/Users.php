<?php

class Teams_Users extends Yachay_Model_Table
{
    protected $_name            = 'team_user';
    protected $_referenceMap    = array(
        'Team'                  => array(
            'columns'           => array('team'),
            'refTableClass'     => 'Teams',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTeamAndUser($team, $user) {
        return $this->fetchRow($this->select()->where('team = ?', $team)->where('user = ?', $user));
    }
}
