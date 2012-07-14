<?php

class Events_Event extends Yachay_Model_Row_Validation
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
            'filters' => array('StringTrim'),
        ),
        'event' => array(
            'filters' => array('Int'),
        ),
        'duration' => array(
            'filters' => array('Int'),
        ),
    );

    public function getResource() {
        $model_resources = new Resources();
        return $model_resources->findByIdent($this->resource);
    }

    public function getLabel() {
        if ($this->priority) {
            return 'aviso';
        } else {
            return 'evento';
        }
    }
}
