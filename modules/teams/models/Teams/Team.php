<?php

class modules_teams_models_Teams_Team extends Yeah_Model_Row_WithUrlAndTsRegister
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
                    'options'   => array('teams'),
                    'message'   => 'El nombre seleccionado para el equipo ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getGroup() {
        $groups = Yeah_Adapter::getModel('groups');
        return $groups->findByIdent($this->group);
    }

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
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

        $users = Yeah_Adapter::getModel('users');
        $assignement = Yeah_Adapter::getModel('teams', 'Teams_Users');
        $user = $users->findByIdent($USER->ident);
        $assign = $assignement->findByTeamAndUser($this->ident, $USER->ident);
        if (!empty($assign)) {
            return true;
        }
        return false;
    }
}
