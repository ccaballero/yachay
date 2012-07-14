<?php

class Regions extends Yachay_Model_Table
{
    protected $_name            = 'region';
    protected $_primary         = 'ident';
    protected $_dependentTables = array('Regions_Pages');
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Region',
        'package'               => 'Paquete',
        'script'                => 'Archivo ejecutado',
        'region'                => 'Tipo de region',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByModuleScript($package, $script) {
        return $this->fetchRow($this->select()
                                    ->where('package = ?', $package)
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
