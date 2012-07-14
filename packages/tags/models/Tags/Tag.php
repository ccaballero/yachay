<?php

class Tags_Tag extends Yachay_Model_Row_Validation
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
                    'options'   => array('Tags'),
                    'message'   => 'El nombre seleccionado para la etiqueta ya existe o no puede utilizarse',
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
                    'message'   => 'El nombre seleccionado para la etiqueta no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('Tags'),
                    'message'   => 'El identificador de etiqueta ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
    );
}
