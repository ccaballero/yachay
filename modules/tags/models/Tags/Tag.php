<?php

class modules_tags_models_Tags_Tag extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim', 'StringToLower'),
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
                    'validator' => 'UniqueLabel',
                    'options'   => array('tags'),
                    'message'   => 'El nombre seleccionado para la etiqueta ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'url' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('areas'),
                    'message'   => 'El identificador de area ya esta siendo usado',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
    );
}
