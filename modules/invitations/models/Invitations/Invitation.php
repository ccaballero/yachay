<?php

class modules_invitations_models_Invitations_Invitation extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'email' => array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El correo electronico del usuario no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El correo electronico del usuario debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'EmailAddress',
                    'message'   => 'El correo electronico del usuario debe ser valido y existir',
                ),
                array(
                    'validator' => 'UniqueEmail',
                    'options'   => array('users'),
                    'message'   => 'El correo electronico seleccionado para el usuario es de un usuario registrado',
                    'namespace' => 'Yeah_Validators',
                ),
                array(
                    'validator' => 'UniqueEmail',
                    'options'   => array('invitations'),
                    'message'   => 'El correo electronico seleccionado para el usuario ya posee una invitacion',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }
}
