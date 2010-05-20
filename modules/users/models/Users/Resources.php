<?php

class modules_users_models_Users_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'user_resource';
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
