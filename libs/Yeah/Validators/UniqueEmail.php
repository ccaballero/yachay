<?php

class Yeah_Validators_UniqueEmail extends Zend_Validate_Abstract
{
    protected $_model;
    protected $_ident;

    public function __construct($model, $ident) {
        $this->_model = $model;
        $this->ident = $ident;
    }

    public function isValid($value) {
        $elements = Yeah_Adapter::getModel($this->_model);
        $element = $elements->findByEmail($value);
        if (empty($element)) {
            return true;
        } else {
            if ($element->ident == $this->ident) {
                return true;
            }
        }
        return false;
    }
}
