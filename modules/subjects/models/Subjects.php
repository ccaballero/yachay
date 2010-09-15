<?php

class modules_subjects_models_Subjects extends Zend_Db_Table_Abstract
{
    protected $_name            = 'subject';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_subjects_models_Subjects_Subject';
    protected $_dependentTables = array('modules_areas_models_Areas_Subjects',
                                        'modules_subjects_models_Subjects_Users',
                                        'modules_subjects_models_Subjects_Resources',
                                        'modules_groups_models_Groups',
                                  );
    protected $_referenceMap    = array(
        'Gestion'               => array(
            'columns'           => 'gestion',
            'refTableClass'     => 'modules_gestions_models_Gestions',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
        'Moderator'             => array(
            'columns'           => 'moderator',
            'refTableClass'     => 'modules_users_models_Users',
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
