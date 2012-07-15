<?php

class Files extends Yachay_Db_Table
{
    protected $_name            = 'file';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Files_File';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByResource($resource) {
        return $this->fetchRow($this->getAdapter()->quoteInto('`resource` = ?', $resource));
    }
}
