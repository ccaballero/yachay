<?php

class Yeah_Validators_UniqueLabel extends Zend_Validate_Abstract
{
    protected $_model;
    protected $_ident;

    public function __construct($model, $ident) {
        $this->_model = $model;
        $this->_ident = $ident;
    }

    public function isValid($value) {
        $model = new $this->_model();
        $element = $model->findByLabel($value);
        if (empty($element)) {
            return true;
        } else {
            if ($element->ident == $this->_ident) {
                return true;
            }
        }
        return false;
    }
}
