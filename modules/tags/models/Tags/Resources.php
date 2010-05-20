<?php

class modules_tags_models_Tags_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'tag_resource';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'modules_tags_models_Tags',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );
}
