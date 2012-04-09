<?php

class Pages_Page extends Yachay_Models_Row_Validation
{
    protected $_validationRules = array(
        'title' => array(
            'filters' => array('StringTrim', 'StripTags'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El titulo de la pagina no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 16),
                    'message'   => 'El titulo de la pagina debe tener entre 1 y 16 caracteres',
                ),
            ),
        ),
        'menutype' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'InArray',
                    'options'   => array(array('', 'menubar', 'secondary', 'footer')),
                    'message'   => 'El tipo de menu no es valido',
                ),
            ),
        ),
        'menuorder' => array(
            'filters' => array('StringTrim', 'Int'),
            'validators' => array(
                array(
                    'validator' => 'Between',
                    'options'   => array(0, 99),
                    'message'   => 'El tipo de menu no es valido',
                ),
            ),
        ),
    );
}
