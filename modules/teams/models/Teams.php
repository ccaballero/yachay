<?php

class modules_teams_models_Teams extends Zend_Db_Table_Abstract
{
    protected $_name            = 'team';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_teams_models_Teams_Team';
    protected $_dependentTables = array('modules_teams_models_Teams_Users',
                                        'modules_teams_models_Teams_Resources',
                                  );
    protected $_referenceMap    = array(
        'Group'                 => array(
            'columns'           => 'group',
            'refTableClass'     => 'modules_groups_models_Groups',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'modules_users_models_Users',
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

    public function findByLabel($group, $label) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('label = ?', $label));
    }

    public function findByUrl($group, $url) {
        return $this->fetchRow($this->select()->where('`group` = ?', $group)->where('url = ?', $url));
    }

    // Selects in table
    public function selectAll($group) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->order('label ASC'));
    }

    public function selectByAuthor($group, $author) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->where('author = ?', $author));
    }

    public function selectByStatus($group, $status) {
        return $this->fetchAll($this->select()->where('`group` = ?', $group)->where('status = ?', $status));
    }
}
