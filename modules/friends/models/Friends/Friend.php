<?php

class Friends_Friend extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'user' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Users'),
                    'message'   => 'El usuario no es valido',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'friend' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('Users'),
                    'message'   => 'El usuario contacto no es valido',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
    );
}
