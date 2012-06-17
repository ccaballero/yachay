<?php

class Photos extends Yachay_Models_Table
{
    protected $_name            = 'photo';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Photos_Photo';
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
