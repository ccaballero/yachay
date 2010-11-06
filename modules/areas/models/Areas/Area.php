<?php

class Areas_Area extends Yeah_Model_Row_Validation
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
                    'validator' => 'UniqueLabel',
                    'options'   => array('areas'),
                    'message'   => 'El nombre seleccionado del area ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'url' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'ReservedWord',
                    'options'   => array(),
                    'message'   => 'El nombre seleccionado del area no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('areas'),
                    'message'   => 'El identificador de area ya esta siendo usado',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function isEmpty() {
        $subjects = $this->findSubjectsViaAreas_Subjects();
        return count($subjects) == 0;
    }
}
