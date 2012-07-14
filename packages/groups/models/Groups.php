<?php

class Groups extends Yachay_Model_Table
{
    protected $_name            = 'group';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Groups_Group';
    protected $_dependentTables = array('Groupsets_Groups',
                                        'Groups_Users',
                                        'Groups_Resources',
                                        'Teams',
                                  );
    protected $_referenceMap    = array(
        'Subject'               => array(
            'columns'           => 'subject',
            'refTableClass'     => 'Subjects',
            'refColumns'        => 'ident',
        ),
        'Author'                => array(
            'columns'           => 'author',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Teacher'               => array(
            'columns'           => 'teacher',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Evaluation'            => array(
            'columns'           => 'evaluation',
            'refTableClass'     => 'Evaluations',
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
