<?php

class modules_groups_models_Groups extends Zend_Db_Table_Abstract
{
    protected $_name            = 'group';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_groups_models_Groups_Group';
    protected $_dependentTables = array('modules_groupsets_models_Groupsets_Groups',
                                        'modules_groups_models_Groups_Users',
                                        'modules_groups_models_Groups_Resources',
                                        'modules_teams_models_Teams',
                                  );
    protected $_referenceMap    = array(
        'Subject'               => array(
            'columns'           => 'subject',
            'refTableClass'     => 'modules_subjects_models_Subjects',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
        'Teacher'               => array(
            'columns'           => 'teacher',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
        'Evaluation'			=> array(
            'columns'			=> 'evaluation',
            'refTableClass'     => 'modules_evaluations_models_Evaluations',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'subject'               => 'Materia',
        'author'                => 'Autor',
        'teacher'               => 'Docente',
        'evaluation'            => 'Forma de evaluacion',
        'label'                 => 'Grupo',
        'url'                   => 'Identificador',
        'status'                => 'Estado',
        'description'           => 'Descripcion',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($subject, $label) {
        return $this->fetchRow($this->select()
                                    ->where('subject = ?', $subject)
                                    ->where('label = ?', $label));
    }

    public function findByUrl($subject, $url) {
        return $this->fetchRow($this->select()
                                    ->where('subject = ?', $subject)
                                    ->where('url = ?', $url));
    }

    // Selects in table
    public function selectAll($subject) {
        return $this->fetchAll($this->select()->where('subject = ?', $subject)->order('label ASC'));
    }

    public function selectByAuthor($subject, $author) {
        return $this->fetchAll($this->select()->where('subject = ?', $subject)->where('author = ?', $author));
    }

    public function selectByTeacher($subject, $teacher) {
        return $this->fetchAll($this->select()->where('subject = ?', $subject)->where('teacher = ?', $teacher));
    }

    public function selectByEvaluation($subject, $evaluation) {
        return $this->fetchAll($this->select()->where('subject = ?', $subject)->where('evaluation = ?', $evaluation));
    }

    public function selectByStatus($subject, $status) {
        return $this->fetchAll($this->select()->where('subject = ?', $subject)->where('status = ?', $status)->order('label ASC'));
    }

    // Especial method
    public function listGroupsWithTeacher($teacher) {
        return $this->fetchAll($this->select()->where('teacher = ?', $teacher));
    }
}
