<?php

class modules_areas_models_Areas extends Zend_Db_Table_Abstract
{
    protected $_name            = 'area';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_areas_models_Areas_Area';
    protected $_dependentTables = array('modules_areas_models_Areas_Subjects',
                                        'modules_areas_models_Areas_Resources',
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
        return $this->fetchAll($this->select());
    }
}
