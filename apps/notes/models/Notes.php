<?php

class Notes extends Yachay_Db_Table
{
    protected $_name            = 'note';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Notes_Note';
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
