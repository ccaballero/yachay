<?php

class Areas extends Yachay_Db_Table
{
    protected $_name            = 'area';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Areas_Area';
    protected $_dependentTables = array('Areas_Subjects',
                                        'Areas_Resources',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Area',
        'url'                   => 'Identificador',
        'description'           => 'Descripcion',
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

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
