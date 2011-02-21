<?php

class Careers extends Yeah_Model_Table
{
    protected $_name            = 'career';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Careers_Career';
    protected $_dependentTables = array('Careers_Subjects',
                                        'Careers_Resources',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Carrera',
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
        return $this->fetchAll($this->select());
    }
}
