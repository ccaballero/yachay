<?php

class modules_widgets_models_Widgets extends Zend_Db_Table_Abstract
{
    protected $_name            = 'widget';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_widgets_models_Widgets_Widget';
    protected $_dependentTables = array('modules_widgets_models_Widgets_Pages',
                                  );
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
