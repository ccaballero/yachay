<?php

class Widgets extends Yeah_Model_Table
{
    protected $_name            = 'widget';
    protected $_primary         = 'ident';
    protected $_dependentTables = array('Widgets_Pages', );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Widget',
        'module'                => 'Modulo',
        'script'                => 'Archivo ejecutado',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByModuleScript($module, $script) {
        return $this->fetchAll($this->select()
                                    ->where('module = ?', $module)
                                    ->where('script = ?', $script));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
