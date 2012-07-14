<?php

class Subjects_Subject extends Yachay_Model_Row_Validation
{
    protected $_foreignkey = 'gestion';

    protected $_validationRules = array(
        'moderator' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Users'),
                    'message'   => 'El usuario designado para ser moderador no es valido',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'HasPrivilege',
                    'options'   => array('subjects', 'moderate'),
                    'message'   => 'El usuario designado para ser moderador no posee los privilegios suficientes',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'code' => array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El codigo de materia no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 16),
                    'message'   => 'El codigo de materia debe tener entre 1 y 16 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[[A-Za-z0-9]+$/i'),
                    'message'   => 'El codigo de materia debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueCodeDual',
                    'options'   => array('Subjects'),
                    'message'   => 'El codigo seleccionado para la materia ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de materia no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de materia debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('Subjects'),
                    'message'   => 'El nombre seleccionado para la materia ya existe o no puede utilizarse',
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
                    'message'   => 'El nombre seleccionado para la materia no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrlDual',
                    'options'   => array('Subjects'),
                    'message'   => 'El identificador de la materia ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'visibility' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'Debe definir la visibilidad de la materia',
                ),
                array(
                    'validator' => 'InArray',
                    'options'   => array(array('public', 'register', 'private')),
                    'message'   => 'La visibilidad seleccionada no es valida',
                ),
            ),
        ),
    );

    public function getGestion() {
        $model_gestions = new Gestions();
        return $model_gestions->findByIdent($this->gestion);
    }

    public function getAuthor() {
        $model_users = new Users();
        return $model_users->findByIdent($this->author);
    }

    public function getModerator() {
        $model_users = new Users();
        return $model_users->findByIdent($this->moderator);
    }

    public function isEmpty() {
        $model_groups = new Groups();
        $groups = $model_groups->selectAll($this->ident);
        return count($groups) == 0;
    }

    public function delete() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->delete('area_subject', 'subject = ' . $this->ident);
        $db->delete('subject_user', 'subject = ' . $this->ident);
        parent::delete();
    }

    public function getAssignement($user) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from('subject_user')->where('subject = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $db->fetchRow($select);
        
        $obj = new stdClass;
        $obj->type = $result['type'];
        $obj->status = $result['status'];
        $obj->tsregister =  $result['tsregister'];

        return $obj;
    }

    public function amModerator() {
        $user = Zend_Registry::get('user');
        return ($this->moderator == $user->ident);
    }

    public function amMember() {
        $user = Zend_Registry::get('user');

        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from('subject_user')->where('subject = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $db->fetchRow($select);
        return ($result <> NULL);
    }
}
