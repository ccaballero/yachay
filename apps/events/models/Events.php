<?php

class Events extends Yachay_Db_Table
{
    protected $_name            = 'event';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Events_Event';
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
