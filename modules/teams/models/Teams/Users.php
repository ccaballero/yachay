<?php

class modules_teams_models_Teams_Users extends Zend_Db_Table_Abstract
{
    protected $_name            = 'team_user';
    protected $_referenceMap    = array(
        'Team'                  => array(
            'columns'           => array('team'),
            'refTableClass'     => 'modules_teams_models_Teams',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTeamAndUser($team, $user) {
        return $this->fetchRow($this->select()->where('team = ?', $team)->where('user = ?', $user));
    }
}
