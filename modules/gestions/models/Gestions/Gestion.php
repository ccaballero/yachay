<?php

class modules_gestions_models_Gestions_Gestion extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la gestion no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la gestion debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('gestions'),
                    'message'   => 'El nombre seleccionado de la gestion ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'url' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('gestions'),
                    'message'   => 'El identificador de gestion ya esta siendo usado',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
    );

    public function isEmpty() {
        $model = Yeah_Adapter::getModel('subjects');
        $subjects = $model->selectAll($this->ident);
        return count($subjects) == 0;
    }
}
