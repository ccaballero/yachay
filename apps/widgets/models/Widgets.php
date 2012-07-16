<?php

class Widgets extends Yachay_Db_Table
{
    protected $_name            = 'widget';
    protected $_primary         = 'ident';
    protected $_dependentTables = array('Widgets_Pages');
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Widget',
        'package'               => 'Paquete',
        'script'                => 'Archivo ejecutado',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByModuleScript($package, $script) {
        return $this->fetchAll($this->select()
                                    ->where('package = ?', $package)
                                    ->where('script = ?', $script));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
