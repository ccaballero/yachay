<?php

class modules_communities_models_Communities extends Zend_Db_Table_Abstract
{
    protected $_name            = 'community';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_communities_models_Communities_Community';
    protected $_dependentTables = array('modules_communities_models_Communities_Petitions',
                                        'modules_communities_models_Communities_Users',
                                        'modules_communities_models_Communities_Resources',
                                  );
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'modules_users_models_Users',
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
