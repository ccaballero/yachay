<?php

class Groups_Group extends Yachay_Models_Row_Validation
{
    protected $_foreignkey = 'subject';

    protected $_validationRules = array(
        'teacher' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Users'),
                    'message'   => 'El usuario designado para ser docente no es valido',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'HasPrivilege',
                    'options'   => array('subjects', 'teach'),
                    'message'   => 'El usuario designado para ser docente no posee los privilegios suficientes',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'evaluation' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Evaluations'),
                    'message'   => 'El criterio de evaluacion designado para el grupo no es valido',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del grupo no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre del grupo debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('Groups'),
                    'message'   => 'El nombre seleccionado para el grupo ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'url' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'ReservedWord',
                    'options'   => array(),
                    'message'   => 'El nombre seleccionado para el grupo no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrlDual',
                    'options'   => array('Groups'),
                    'message'   => 'El identificador de grupo ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getSubject() {
        $model_subjects = new Subjects();
        return $model_subjects->findByIdent($this->subject);
    }

    public function getAuthor() {
        $model_users = new Users();
        return $model_users->findByIdent($this->author);
    }

    public function getTeacher() {
        $model_users = new Users();
        return $model_users->findByIdent($this->teacher);
    }

    public function getEvaluation() {
        $model_evaluations = new Evaluations();
        return $model_evaluations->findByIdent($this->evaluation);
    }

    public function isEmpty() {
        $model_teams = new Teams();
        $teams = $model_teams->selectAll($this->ident);
        return count($teams) == 0;
    }

    public function delete() {
        // FIXME ??
        global $DB;
        $DB->delete('groupset_group', '`group` = ' . $this->ident);
        $DB->delete('group_user', '`group` = ' . $this->ident);
        parent::delete();
    }

    public function getAssignement($user) {
        global $DB;
        $select = $DB->select()->from('group_user')->where('`group` = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $DB->fetchRow($select);

        $obj = new stdClass;
        $obj->type = $result['type'];
        $obj->status = $result['status'];
        $obj->tsregister =  $result['tsregister'];

        return $obj;
    }

    public function amTeacher() {
        global $USER;
        return ($this->teacher == $USER->ident);
    }

    public function amMember() {
        global $DB;
        global $USER;
        $select = $DB->select()->from('group_user')->where('`group` = ?' , $this->ident)->where('user = ?', $USER->ident);
        $result = $DB->fetchRow($select);
        return ($result <> NULL);
    }
}
