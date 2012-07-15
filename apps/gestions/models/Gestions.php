<?php

class Gestions extends Yachay_Db_Table
{
    protected $_name            = 'gestion';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Gestions_Gestion';
    protected $_dependentTables = array('Subjects', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Gestion',
        'url'                   => 'Identificador',
        'status'                => 'Estado',
        'tsregister'            => 'Fecha de Registro',
    );

    public function desactiveAll() {
        $array = array(
            'status' => 'inactive',
        );
        $this->update($array, '');
    }

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

    public function findByActive() {
        return $this->fetchRow($this->getAdapter()->quoteInto('status = ?', 'active'));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status));
    }
}
