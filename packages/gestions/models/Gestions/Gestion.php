<?php

class Gestions_Gestion extends Yachay_Models_Row_Validation
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
                    'options'   => array('Gestions'),
                    'message'   => 'El nombre seleccionado de la gestion ya existe o no puede utilizarse',
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
                    'message'   => 'El nombre seleccionado de la gestión no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('Gestions'),
                    'message'   => 'El identificador de gestion ya esta siendo usado',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
    );

    public function isEmpty() {
        $model_subjects = new Subjects();
        $subjects = $model_subjects->selectAll($this->ident);
        return count($subjects) == 0;
    }
}
