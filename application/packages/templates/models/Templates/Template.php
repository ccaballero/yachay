<?php

class Templates_Template extends Yachay_Models_Row_Validation
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del tema no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(4, 64),
                    'message'   => 'El nombre del tema debe tener entre 4 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('Templates'),
                    'message'   => 'El nombre seleccionado para el tema ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );
}
