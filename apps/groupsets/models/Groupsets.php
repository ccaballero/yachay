<?php

class Groupsets extends Yachay_Model_Table
{
    protected $_name            = 'groupset';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Groupsets_Groupset';
    protected $_dependentTables = array('Groupsets_Groups', );
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Gestion'               => array(
            'columns'           => 'gestion',
            'refTableClass'     => 'Gestions',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'author'                => 'Autor',
        'gestion'               => 'Gestion',
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
