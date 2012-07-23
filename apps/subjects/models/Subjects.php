<?php

class Subjects extends Yachay_Db_Table
{
    protected $_name            = 'subject';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Subjects_Subject';
    protected $_dependentTables = array('Areas_Subjects',
                                        'Careers_Subjects',
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

    public function findByCode($code, $gestion = null) {
        return $this->fetchRow($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('code = ?', $code));
    }

    public function findByLabel($label, $gestion = null) {
        return $this->fetchRow($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('label = ?', $label));
    }

    public function findByUrl($url, $gestion = null) {
        return $this->fetchRow($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('url = ?', $url));
    }

    // Selects in table
    public function selectAll($gestion = null) {
        return $this->fetchAll($this->select()->where('gestion = ?', $this->getGestion($gestion))->order('label ASC'));
    }

    public function selectByAuthor($author, $gestion = null) {
        return $this->fetchAll($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('author = ?', $author));
    }

    public function selectByModerator($moderator, $gestion = null) {
        return $this->fetchAll($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('moderator = ?', $moderator));
    }

    public function selectByStatus($status, $gestion = null) {
        return $this->fetchAll($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('status = ?', $status)->order('label ASC'));
    }

    public function selectByVisibility($visibility, $gestion = null) {
        return $this->fetchAll($this->select()->where('gestion = ?', $this->getGestion($gestion))->where('visibility = ?', $visibility)->order('label ASC'));
    }

    private function getGestion($gestion) {
        if ($gestion == null) {
            $model_gestions = new Gestions();
            $gestion = $model_gestions->findByActive();
            $ident_gestion = $gestion->ident;
        } else {
            $ident_gestion = intval($gestion);
        }
        
        return $ident_gestion;
    }
}
