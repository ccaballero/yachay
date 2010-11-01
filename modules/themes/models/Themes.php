<?php

class modules_themes_models_Themes extends Zend_Db_Table_Abstract
{
    protected $_name            = 'theme';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_themes_models_Themes_Theme';
    protected $_dependentTables = array('modules_users_models_Users',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Tema',
        'description'           => 'Descripción',
        'doctype'               => 'Tipo de HTML',
        'properties'            => 'Propiedades',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
