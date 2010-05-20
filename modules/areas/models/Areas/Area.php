<?php

class modules_areas_models_Areas_Area extends Yeah_Model_Row_WithUrlAndTsRegister
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del area no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 15),
                    'message'   => 'El nombre del area debe tener entre 1 y 15 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El nombre del area debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('areas'),
                    'message'   => 'El nombre seleccionado del area ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function isEmpty() {
        $subjects = $this->findManyToManyRowset('modules_subjects_models_Subjects', 'modules_areas_models_Areas_Subjects');
        return count($subjects) == 0;
    }
}
