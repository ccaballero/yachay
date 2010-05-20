<?php

class modules_teams_models_Teams_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'team_resource';
    protected $_referenceMap    = array(
        'Team'                  => array(
            'columns'           => array('team'),
            'refTableClass'     => 'modules_teams_models_Teams',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
