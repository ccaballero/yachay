<?php

class Files_File extends Yeah_Model_Row_Validation
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
