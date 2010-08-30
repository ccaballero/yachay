<?php

class modules_communities_models_Communities_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'community_resource';
    protected $_referenceMap    = array(
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'modules_communities_models_Communities',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
