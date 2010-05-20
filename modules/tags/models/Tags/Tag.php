<?php

class modules_tags_models_Tags_Tag extends Yeah_Model_Row_WithTsRegister
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la etiqueta no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la etiqueta debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El nombre de la etiqueta debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('tags'),
                    'message'   => 'El nombre seleccionado para la etiqueta ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
    );
}
