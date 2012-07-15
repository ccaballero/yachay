<?php

class Ratings extends Yachay_Db_Table
{
    protected $_name            = 'rating';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => 'resource',
            'refTableClass'     => 'Resources',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
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
