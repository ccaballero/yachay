<?php

class Communities extends Yeah_Model_Table
{
    protected $_name            = 'community';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Communities_Community';
    protected $_dependentTables = array('Communities_Petitions', 'Communities_Users', 'Communities_Resources', );
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'author'                => 'Creador',
        'label'                 => 'Comunidad',
        'url'                   => 'Identificador',
        'mode'                  => 'Tipo de acceso',
        'members'               => 'Miembros',
        'description'           => 'Descripcion',
        'avatar'                => 'Tiene avatar',
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

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author));
    }
}
