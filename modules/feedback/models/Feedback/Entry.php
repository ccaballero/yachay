<?php

class modules_feedback_models_Feedback_Entry extends Yeah_Model_Row_Validation
{
    public $__type = 'entry';
    public $__element = 'feedback';
    public $__label = 'sugerencia';

    protected $_validationRules = array(
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getResource() {
        $resources = Yeah_Adapter::getModel('resources');
        return $resources->findByIdent($this->resource);
    }
}
