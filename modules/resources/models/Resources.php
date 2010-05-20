<?php

class modules_resources_models_Resources extends Zend_Db_Table_Abstract
{
    protected $_name            = 'resource';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_resources_models_Resources_Resource';
    protected $_dependentTables = array('modules_resources_models_Resources_Globales',
                                        'modules_resources_models_Areas_Resources',
                                        'modules_resources_models_Subjects_Resources',
                                        'modules_resources_models_Groups_Resources',
                                        'modules_resources_models_Teams_Resources',
                                        'modules_resources_models_Users_Resources',
                                        'modules_tags_models_Tags_Resources',
                                        'modules_comments_models_Comments',
                                        'modules_notes_models_Notes',
                                        'modules_files_models_Files',
                                        'modules_events_models_Events',
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
        'author'                => 'Autor',
        'ratings'               => 'Valoracion',
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
