<?php

class modules_events_models_Events extends Zend_Db_Table_Abstract
{
    protected $_name            = 'event';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'modules_events_models_Events_Event';
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
