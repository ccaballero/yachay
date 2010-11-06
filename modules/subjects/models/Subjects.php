<?php

class Subjects extends Yeah_Model_Table
{
    protected $_name            = 'subject';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Subjects_Subject';
    protected $_dependentTables = array('Areas_Subjects',
                                        'Subjects_Users',
                                        'Subjects_Resources',
                                        'Groups',
                                  );
    protected $_referenceMap    = array(
        'Gestion'               => array(
            'columns'           => 'gestion',
            'refTableClass'     => 'Gestions',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Moderator'             => array(
            'columns'           => 'moderator',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Código',
        'gestion'               => 'Gestión',
        'author'                => 'Autor',
        'moderator'             => 'Moderador',
        'code'                  => 'Código',
        'label'                 => 'Materia',
        'url'                   => 'Identificador',
        'status'                => 'Estado',
        'visibility'            => 'Visibilidad',
        'description'           => 'Descripción',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByCode($gestion, $code) {
        return $this->fetchRow($this->select()->where('gestion = ?', $gestion)->where('code = ?', $code));
    }

    public function findByLabel($gestion, $label) {
        return $this->fetchRow($this->select()->where('gestion = ?', $gestion)->where('label = ?', $label));
    }

    public function findByUrl($gestion, $url) {
        return $this->fetchRow($this->select()->where('gestion = ?', $gestion)->where('url = ?', $url));
    }

    // Selects in table
    public function selectAll($gestion) {
        return $this->fetchAll($this->select()->where('gestion = ?', $gestion)->order('label ASC'));
    }

    public function selectByAuthor($gestion, $author) {
        return $this->fetchAll($this->select()->where('gestion = ?', $gestion)->where('author = ?', $author));
    }

    public function selectByModerator($gestion, $moderator) {
        return $this->fetchAll($this->select()->where('gestion = ?', $gestion)->where('moderator = ?', $moderator));
    }

    public function selectByStatus($gestion, $status) {
        return $this->fetchAll($this->select()->where('gestion = ?', $gestion)->where('status = ?', $status)->order('label ASC'));
    }

    public function selectByVisibility($gestion, $visibility) {
        return $this->fetchAll($this->select()->where('gestion = ?', $gestion)->where('visibility = ?', $visibility)->order('label ASC'));
    }
}
