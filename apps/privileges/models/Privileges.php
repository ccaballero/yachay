<?php

class Privileges extends Yachay_Model_Table
{
    protected $_name            = 'privilege';
    protected $_primary         = 'ident';
    protected $_dependentTables = array('Roles_Privileges', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Privilegio',
        'package'               => 'Paquete',
        'privilege'             => 'Función',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByModulePrivilege($package, $privilege) {
        return $this->fetchAll($this->select()
                                    ->where('package = ?', $package)
                                    ->where('privilege = ?', $privilege));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('package ASC')->order('privilege ASC'));
    }
}
