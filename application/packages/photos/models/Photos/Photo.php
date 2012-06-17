<?php

class Photos_Photo extends Yachay_Models_Row_Validation
{
    public $__type = 'photo';
    public $__element = 'photos';

    protected $_validationRules = array(
        'size' => array(
            'filters' => array('Int'),
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
            return 'fotografía';
        }
    }
}
