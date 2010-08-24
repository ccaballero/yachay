<?php

class modules_users_models_Users_User extends Yeah_Model_Row_WithUrlAndTsRegister
{
    protected $_validationRules = array(
        'role' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('roles'),
                    'message'   => 'El rol seleccionado no es valido',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'code' => array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El codigo de usuario no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 16),
                    'message'   => 'El codigo de usuario debe tener entre 1 y 16 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[[A-Za-z0-9]+$/i'),
                    'message'   => 'El codigo de usuario debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueCode',
                    'options'   => array('users'),
                    'message'   => 'El codigo seleccionado para el usuario ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de usuario no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(4, 64),
                    'message'   => 'El nombre de usuario debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El nombre de usuario debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('users'),
                    'message'   => 'El nombre seleccionado para el usuario ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
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
                    'message'   => 'El correo electronico seleccionado para el usuario ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'surname' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'El apellido debe tener entre 1 y 128 caracteres',
                ),
            ),
        ),
        'name' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'El nombre debe tener entre 1 y 128 caracteres',
                ),
            ),
        ),
        'birthdate' => array(
            'filters' => array('StringTrim', 'StripTags'),
        ),
        'career' => array(
            'filters' => array('StringTrim', 'StripTags'),
        ),
        'phone' => array(
            'filters' => array('StringTrim', 'StripTags'),
        ),
        'cellphone' => array(
            'filters' => array('StringTrim', 'StripTags'),
        ),
        'hobbies' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'interests' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'sign' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'La firma debe tener entre 0 y 128 caracteres',
                ),
            ),
        ),
    );

    public $_acl = array();

    public function hasPermission($module, $privilege) {
        if (count($this->_acl) == 0) {
            $roles = Yeah_Adapter::getModel('roles');
            $role = $roles->findByIdent($this->role);
            $privileges = $role->findManyToManyRowset('modules_privileges_models_Privileges', 'modules_roles_models_Roles_Privileges');

            foreach ($privileges as $priv) {
                $this->_acl[] = $priv->module . '_' . $priv->privilege;
            }
        }
        return in_array($module . '_' . $privilege, $this->_acl);
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }

    public function getRole() {
        $roles = Yeah_Adapter::getModel('roles');
        return $roles->findByIdent($this->role);
    }

    public function lastLogin() {
        //$this->tslastlogin = time();
        //return parent::save();
    }

    public function getAvatar() {
        if ($this->avatar) {
            return $this->ident . '.jpg';
        } else {
            return '0.jpg';
        }
    }
}
