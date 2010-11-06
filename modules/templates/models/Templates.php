<?php

class Templates extends Yeah_Model_Table
{
    protected $_name            = 'template';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Templates_Template';
    protected $_dependentTables = array('Users', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Tema',
        'description'           => 'Descripción',
        'doctype'               => 'Tipo de HTML',
        'properties'            => 'Propiedades',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
