<?php

class modules_files_models_Files extends Zend_Db_Table_Abstract
{
    protected $_name            = 'file';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'modules_files_models_Files_File';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByResource($resource) {
        return $this->fetchRow($this->getAdapter()->quoteInto('`resource` = ?', $resource));
    }
}
