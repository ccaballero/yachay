<?php

class modules_tags_models_Tags extends Zend_Db_Table_Abstract
{
    protected $_name            = 'tag';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_tags_models_Tags_Tag';
    protected $_dependentTables = array('modules_tags_models_Tags_Resources',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Etiqueta',
        'weigth'                => 'Peso',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }
}
