<?php

class modules_comments_models_Comments extends Zend_Db_Table_Abstract
{
    protected $_name            = 'comment';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_comments_models_Comments_Comment';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => 'resource',
            'refTableClass'     => 'modules_resources_models_Resources',
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
        'resource'              => 'Recurso',
        'author'                => 'Autor',
        'comment'               => 'Comentario',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByResource($resource) {
        return $this->fetchAll($this->select()->where('resource = ?', $resource));
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author));
    }
}
