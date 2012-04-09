<?php

class Modules extends Yachay_Models_Table
{
    protected $_name            = 'module';
    protected $_primary         = 'ident';
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Modulo',
        'url'                   => 'Identificador',
        'status'                => 'Estado',
        'type'                  => 'Tipo',
        'description'           => 'Descripcion',
        'tsregister'            => 'Fecha de Registro',
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

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status));
    }

    public function selectByType($type) {
        return $this->fetchAll($this->select()->where('type = ?', $type));
    }
}
