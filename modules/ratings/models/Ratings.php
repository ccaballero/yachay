<?php

class modules_ratings_models_Ratings extends Zend_Db_Table_Abstract
{
    protected $_name            = 'rating';
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
        'resource'              => 'Recurso',
        'author'                => 'Autor',
        'rating'                => 'Valoración',
    );

    public function findByResourceAndAuthor($resource, $author) {
        return $this->fetchRow($this->select()->where('`resource` = ?', $resource)->where('`author` = ?', $author));
    }

    // Selects in table
    public function selectByResource($resource) {
        return $this->fetchAll($this->select()->where('`resource` = ?', $resource));
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('`author` = ?', $author));
    }
}
