<?php

class modules_tags_models_Tags extends Zend_Db_Table_Abstract
{
    protected $_name            = 'tag';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_tags_models_Tags_Tag';
    protected $_dependentTables = array('modules_tags_models_Tags_Resources',
                                        'modules_tags_models_Tags_Communities',
                                        'modules_tags_models_Tags_Users',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Etiqueta',
        'url'                   => 'Identificador',
        'weight'                => 'Peso',
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

    public function findMaxWeight() {
        $stmt = $this->fetchRow($this->select()->from($this, array('MAX(weight) as max')));
        return $stmt->max;
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }
}
