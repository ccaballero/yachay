<?php

class modules_notes_models_Notes extends Zend_Db_Table_Abstract
{
    protected $_name            = 'note';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'modules_notes_models_Notes_Note';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'modules_resources_models_Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByResource($resource) {
        return $this->fetchRow($this->getAdapter()->quoteInto('resource = ?', $resource));
    }
}
