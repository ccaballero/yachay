<?php

class modules_communities_models_Communities_Community extends Yeah_Model_Row_WithTsRegister
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la comunidad no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la comunidad debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El nombre de la comunidad debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('communities'),
                    'message'   => 'El nombre seleccionado para la comunidad ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'mode' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'Debe definir la modalidad de la comunidad',
                ),
                array(
                    'validator' => 'InArray',
                    'options'   => array(array('open', 'close')),
                    'message'   => 'La modalidad seleccionada no es valida',
                ),
            ),
        ),
        'interests' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }

    public function getAvatar() {
        if ($this->avatar) {
            return $this->ident . '.jpg';
        } else {
            return '0.jpg';
        }
    }
}
