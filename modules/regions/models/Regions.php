<?php

class Regions extends Yeah_Model_Table
{
    protected $_name            = 'region';
    protected $_primary         = 'ident';
    protected $_dependentTables = array('Regions_Pages', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Region',
        'module'                => 'Modulo',
        'script'                => 'Archivo ejecutado',
        'region'                => 'Tipo de region',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByModuleScript($module, $script) {
        return $this->fetchRow($this->select()
                                    ->where('module = ?', $module)
                                    ->where('script = ?', $script));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByRegion($region) {
        return $this->fetchAll($this->select()->where('region = ?', $region)->order('label ASC'));
    }
}
