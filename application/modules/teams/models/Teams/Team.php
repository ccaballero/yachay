<?php

class Teams_Team extends Yachay_Models_Row_Validation
{
    protected $_foreignkey = 'group';

    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del equipo no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre del equipo debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('Teams'),
                    'message'   => 'El nombre seleccionado para el equipo ya existe o no puede utilizarse',
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
                    'message'   => 'El nombre seleccionado para el equipo no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrlDual',
                    'options'   => array('Teams'),
                    'message'   => 'El identificador de equipo ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getGroup() {
        $model_groups = new Groups();
        return $model_groups->findByIdent($this->group);
    }

    public function getAuthor() {
        $model_users = new Users();
        return $model_users->findByIdent($this->author);
    }

    public function delete() {
        // FIXME ??
        global $DB;
        $DB->delete('team_user', 'team = ' . $this->ident);
        parent::delete();
    }

    public function getAssignement($user) {
        global $DB;
        $select = $DB->select()->from('team_user')->where('team = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $DB->fetchRow($select);
        
        $obj = new stdClass;
        $obj->type = $result['type'];
        $obj->status = $result['status'];
        $obj->tsregister =  $result['tsregister'];

        return $obj;
    }

    public function amMemberTeam() {
        global $USER;

        $group = $this->getGroup();
        if ($group->teacher == $USER->ident) {
            return true;
        }

        $model_users = new Users();
        $model_teams_users = new Teams_Users();
        $user = $model_users->findByIdent($USER->ident);
        $assign = $model_teams_users->findByTeamAndUser($this->ident, $USER->ident);
        if (!empty($assign)) {
            return true;
        }
        return false;
    }
}
