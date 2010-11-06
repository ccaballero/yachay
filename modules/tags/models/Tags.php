<?php

class Tags extends Yeah_Model_Table
{
    protected $_name            = 'tag';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Tags_Tag';
    protected $_dependentTables = array('Tags_Resources', 'Tags_Communities', 'Tags_Users', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Etiqueta',
        'url'                   => 'Identificador',
        'weight'                => 'Peso',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    public function findMaxWeight() {
        $stmt = $this->fetchRow($this->select()->from($this, array('MAX(weight) as max')));
        return $stmt->max;
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }
}
