<?php

class Notes_Note extends Yeah_Model_Row_Validation
{
    public $__type = 'note';
    public $__element = 'notes';

    protected $_validationRules = array(
        'note' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El mensaje en su nota no puede estar vacio',
                ),
            ),
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
            return 'nota';
        }
    }
}

