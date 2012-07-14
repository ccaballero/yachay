<?php

class Links extends Yachay_Model_Table
{
    protected $_name            = 'link';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Links_Link';
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
