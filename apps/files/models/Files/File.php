<?php

class Files_File extends Yachay_Model_Row_Validation
{
    public $__type = 'file';
    public $__element = 'files';

    protected $_validationRules = array(
        'size' => array(
            'filters' => array('Int'),
        ),
        'mime' => array(
            'filters' => array('StringTrim', 'StripTags'),
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
            return 'archivo';
        }
    }
}
