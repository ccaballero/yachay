<?php

class Evaluations extends Yachay_Db_Table
{
    protected $_name            = 'evaluation';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Evaluations_Evaluation';
    protected $_dependentTables = array('Groups', 'Evaluations_Tests');
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'author'                => 'Autor',
        'label'                 => 'Materia',
        'description'           => 'Descripción',
        'access'                => 'Accesibilidad',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($author, $label) {
        return $this->fetchRow($this->select()
                                    ->where('author = ?', $author)
                                    ->where('label = ?', $label));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author)->order('label ASC'));
    }

    public function selectByAccess($access) {
        return $this->fetchAll($this->select()->where('access = ?', $access)->order('label ASC'));
    }
}
