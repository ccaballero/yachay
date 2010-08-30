<?php

class modules_roles_models_Roles_Role extends Yeah_Model_Row_WithUrlAndTsRegister
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del rol no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre del rol debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('roles'),
                    'message'   => 'El nombre seleccionado del rol ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function isEmpty() {
        // Set for visitors
        if ($this->ident == 1) {
            return false;
        }
        $model = Yeah_Adapter::getModel('users');
        $users= $model->selectByRole($this->ident);
        return count($users) == 0;
    }
}
