<?php

class Links_Link extends Yachay_Model_Row_Validation
{
    public $__type = 'link';
    public $__element = 'links';

    protected $_validationRules = array(
        'link' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El enlace no puede estar vacio',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim'),
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
            return 'enlace';
        }
    }
}

