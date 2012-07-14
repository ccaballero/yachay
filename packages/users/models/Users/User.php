<?php

class Users_User extends Yachay_Model_Row_Validation
{
    protected $_validationRules = array(
        'role' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Roles'),
                    'message'   => 'El rol seleccionado no es valido',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'code' => array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 16),
                    'message'   => 'El codigo de usuario debe tener entre 0 y 16 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[[A-Za-z0-9]*$/i'),
                    'message'   => 'El codigo de usuario debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueCodeOrNull',
                    'options'   => array('Users'),
                    'message'   => 'El codigo seleccionado para el usuario ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
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
                    'message'   => 'El nombre de usuario debe tener entre 4 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('Users'),
                    'message'   => 'El nombre seleccionado para el usuario ya existe o no puede utilizarse',
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
                    'message'   => 'El nombre seleccionado para el usuario no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('Users'),
                    'message'   => 'El identificador de usuario ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'email' => array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 64),
                    'message'   => 'El correo electronico del usuario debe tener entre 0 y 64 caracteres',
                ),
                array(
                    'validator' => 'EmailAddressOrNull',
                    'options'   => array(),
                    'message'   => 'El correo electronico del usuario debe ser valido y existir',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueEmail',
                    'options'   => array('Users'),
                    'message'   => 'El correo electronico seleccionado para el usuario ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'formalname' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'El nombre completo debe tener entre 0 y 128 caracteres',
                ),
            ),
        ),
        'surname' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'El apellido debe tener entre 0 y 128 caracteres',
                ),
            ),
        ),
        'name' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'StringLength',
                    'options'   => array(0, 128),
                    'message'   => 'El nombre debe tener entre 0 y 128 caracteres',
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

    public function hasPermission($package, $privilege) {
        if (count($this->_acl) == 0) {
            $model_roles = new Roles();
            $role = $model_roles->findByIdent($this->role);
            $privileges = $role->findPrivilegesViaRoles_Privileges();

            foreach ($privileges as $priv) {
                $this->_acl[] = $priv->package . '_' . $priv->privilege;
            }
        }
        return in_array($package . '_' . $privilege, $this->_acl);
    }

    public function hasFewerPrivileges($user) {
        $model_roles = new Roles();

        $roles_allowed = $model_roles->selectByIncludes($this->role);
        foreach ($roles_allowed as $role_allowed) {
            if ($role_allowed->ident == $user->role) {
                return true;
            }
        }
    }

    public function getFullName() {
        if (!empty($this->name) || !empty($this->surname)) {
            return "{$this->name} {$this->surname}";
        } else {
            return $this->label;
        }
    }

    public function getRole() {
        $model_roles = new Roles();
        return $model_roles->findByIdent($this->role);
    }

    public function getCareer() {
        $model_careers = new Careers();
        $career = $model_careers->findByIdent($this->career);
        return !empty($career) ? $career : new Careers_Empty();
    }

    public function needFillProfile() {
        if (empty($this->email) || empty($this->surname) || empty($this->name)) {
            return true;
        } else {
            return false;
        }
    }

    public function lastLogin() {
        $this->tslastlogin = time();
        return parent::save();
    }

    public function getAvatar() {
        if (file_exists(APPLICATION_PATH . '/public/media/users/thumbnail_medium/' . $this->ident . '.jpg')) {
            return $this->ident . '.jpg';
        } else {
            return '0.jpg';
        }
    }

    public function save() {
        if ($this->email == '') {
            unset($this->email);
        }
        parent::save();
    }

    public function getTags() {
        return $this->findTagsViaTags_Users();
    }
}
