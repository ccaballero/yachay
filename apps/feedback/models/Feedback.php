<?php

class Feedback extends Yachay_Model_Table
{
    protected $_name            = 'feedback';
    protected $_primary         = 'resource';
    protected $_rowClass        = 'Feedback_Entry';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );
    public    $_mapping         = array(
        'resource'              => 'Recurso',
        'description'           => 'Descripción',
        'resolved'              => 'Resuelto',
        'mark'                  => 'Favorito',
        'tsregister'            => 'Fecha de registro',
    );

    public function findByResource($resource) {
        return $this->fetchRow($this->getAdapter()->quoteInto('`resource` = ?', $resource));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByResolved($resolved) {
        return $this->fetchAll($this->select()->where('`resolved` = ?', $resolved));
    }

    public function selectByMark($mark) {
        return $this->fetchAll($this->select()->where('`mark` = ?', $mark));
    }
}
