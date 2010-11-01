<?php

class modules_notes_models_Notes_Note extends Yeah_Model_Row_Validation
{
    public $__type = 'note';
    public $__element = 'notes';
    public $__label = 'nota';

    protected $_validationRules = array(
        'note' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getResource() {
        $resources = Yeah_Adapter::getModel('resources');
        return $resources->findByIdent($this->resource);
    }
}
