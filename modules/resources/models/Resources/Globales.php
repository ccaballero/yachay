<?php

class modules_resources_models_Resources_Globales extends Zend_Db_Table_Abstract
{
    protected $_name            = 'resource_global';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function selectAll() {
        return $this->fetchAll($this->select()->order('tsregister DESC'));
    }
}
