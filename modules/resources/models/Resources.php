<?php

class Resources extends Yeah_Model_Table
{
    protected $_name            = 'resource';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Resources_Resource';
    protected $_dependentTables = array('Resources_Globales',
                                        'Areas_Resources',
                                        'Subjects_Resources',
                                        'Groups_Resources',
                                        'Teams_Resources',
                                        'Communities_Resources',
                                        'Users_Resources',
                                        'Notes', 'Links', 'Files', 'Events', 'Photos', 'Videos', 'Feedback',
                                        'Comments', 'Tags_Resources',
                                  );
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'author'                => 'Autor',
        'comments'              => 'Comentarios',
        'ratings'               => 'Valoración',
        'raters'                => 'Votantes',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('tsregister DESC'));
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author));
    }
}
