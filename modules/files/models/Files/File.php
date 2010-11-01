<?php

class modules_files_models_Files_File extends Yeah_Model_Row_Validation
{
    public $__type = 'file';
    public $__element = 'files';
    public $__label = 'archivo';

    protected $_validationRules = array(
        'size' => array(
            'filters' => array('Int'),
        ),
        'mime' => array(
            'filters' => array('StringTrim', 'StripTags'),
        ),
    );

    public function getResource() {
        $resources = Yeah_Adapter::getModel('resources');
        return $resources->findByIdent($this->resource);
    }
}
