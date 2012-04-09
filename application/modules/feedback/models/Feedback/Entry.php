<?php

class Feedback_Entry extends Yachay_Models_Row_Validation
{
    public $__type = 'entry';
    public $__element = 'feedback';

    protected $_validationRules = array(
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getResource() {
        $model_resources = new Resources();
        return $model_resources->findByIdent($this->resource);
    }

    public function getLabel() {
        return 'sugerencia';
    }
}
