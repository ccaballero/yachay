<?php

class modules_friends_models_Friends_Friend extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'user' => array(
            'filters' => array('Int'),
            'validators' => array(
                array(
                    'validator' => 'IdentExists',
                    'options'   => array('users'),
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
                    'options'   => array('users'),
                    'message'   => 'El usuario contacto no es valido',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
    );
}
