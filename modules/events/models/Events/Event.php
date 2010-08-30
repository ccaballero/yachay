<?php

class modules_events_models_Events_Event extends Yeah_Model_Row_Validation
{
    public $__type = 'event';
    public $__element = 'events';

    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre del evento no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre del evento debe tener entre 1 y 64 caracteres',
                ),
            ),
        ),
        'place' => array(
            'filters' => array('StringTrim'),
        ),
        'message' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'event' => array(
            'filters' => array('Int'),
        ),
        'duration' => array(
            'filters' => array('Int'),
        ),
    );

    public function getResource() {
        $resources = Yeah_Adapter::getModel('resources');
        return $resources->findByIdent($this->resource);
    }
}
