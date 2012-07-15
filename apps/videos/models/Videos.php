<?php

class Videos extends Yachay_Db_Table
{
    protected $_name            = 'video';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Videos_Video';
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
