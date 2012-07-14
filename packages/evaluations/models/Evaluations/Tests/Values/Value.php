<?php

class Evaluations_Tests_Values_Value extends Yachay_Model_Row_Validation
{
    protected $_foreignkey = 'test';

    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El valor cualitativo no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El valor cualitativo debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('Evaluations_Tests_Values'),
                    'message'   => 'El valor cualitativo ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'value' => array(
            'filters' => array('StringTrim', 'Int'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El valor de la nota no puede estar vacio', 
                ),
                array(
                    'validator' => 'Between',
                    'options'   => array(0, 100),
                    'message'   => 'El valor de la nota no es valida',
                ),
                array(
                    'validator' => 'UniqueValueDual',
                    'options'   => array('Evaluations_Tests_Values'),
                    'message'   => 'El valor de la nota ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
    );
}
