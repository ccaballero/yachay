<?php

class Teams extends Yachay_Db_Table
{
    protected $_name            = 'team';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Teams_Team';
    protected $_dependentTables = array('Teams_Users', 'Teams_Resources');
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => 'group',
            'refTableClass'     => 'Groups',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'group'                 => 'Grupo',
        'author'                => 'Autor',
        'label'                 => 'Equipo',
        'url'                   => 'Identificador',
        'status'                => 'Estado',
        'description'           => 'Descripcion',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label, $group = null) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('label = ?', $label));
    }

    public function findByUrl($url, $group = null) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('url = ?', $url));
    }

    // Selects in table
    public function selectAll($group = null) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->order('label ASC'));
    }

    public function selectByAuthor($author, $group = null) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->where('author = ?', $author));
    }

    public function selectByStatus($status, $group = null) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->where('status = ?', $status));
    }
}
