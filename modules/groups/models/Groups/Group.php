<?php

class modules_groups_models_Groups_Group extends Yeah_Model_Row_WithUrlAndTsRegister
{
    protected $_foreignkey = 'subject';

    protected $_validationRules = array(
        'teacher' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('users'),
                    'message'   => 'El usuario designado para ser docente no es valido',
                    'namespace' => 'Yeah_Validators',
                ),
                array(
                    'validator' => 'HasPrivilege',
                    'options'   => array('subjects', 'teach'),
                    'message'   => 'El usuario designado para ser docente no posee los privilegios suficientes',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'evaluation' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('evaluations'),
                    'message'   => 'El criterio de evaluacion designado para el grupo no es valido',
                    'namespace' => 'Yeah_Validators',
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
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El nombre del grupo debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('groups'),
                    'message'   => 'El nombre seleccionado para el grupo ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getSubject() {
        $subjects = Yeah_Adapter::getModel('subjects');
        return $subjects->findByIdent($this->subject);
    }

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }

    public function getTeacher() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->teacher);
    }

    public function getEvaluation() {
        $evaluations = Yeah_Adapter::getModel('evaluations');
        return $evaluations->findByIdent($this->evaluation);
    }

    public function isEmpty() {
        $model = Yeah_Adapter::getModel('teams');
        $teams = $model->selectAll($this->ident);
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
}
