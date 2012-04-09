<?php

class Groupsets_Groupset extends Yachay_Models_Row_Validation
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del conjunto no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre del conjunto debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('Groupsets'),
                    'message'   => 'El nombre seleccionado para el conjunto ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
    );

    public function getAuthor() {
        $model_users = new Users();
        return $model_users->findByIdent($this->author);
    }
}
