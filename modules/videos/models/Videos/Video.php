<?php

class Videos_Video extends Yeah_Model_Row_Validation
{
    public $__type = 'video';
    public $__element = 'videos';

    protected $_validationRules = array(
        'size' => array(
            'filters' => array('Int'),
        ),
        'proportion' => array(
            'filters' => array('StringTrim'),
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
            return 'video';
        }
    }
}
