<?php

class modules_groupsets_models_Groupsets extends Zend_Db_Table_Abstract
{
    protected $_name            = 'groupset';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_groupsets_models_Groupsets_Groupset';
    protected $_dependentTables = array('modules_groupsets_models_Groupsets_Groups',
                                  );
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
        'Gestion'			    => array(
            'columns'			=> 'gestion',
            'refTableClass'		=> 'modules_gestions_models_Gestions',
            'refColumns'		=> 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'author'                => 'Autor',
        'gestion'			    => 'Gestion',
        'label'                 => 'Conjunto',
        'tsregister'            => 'Fecha de registro',
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
        return $this->fetchAll($this->select());
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author));
    }
}
