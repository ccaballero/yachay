<?php

class Yeah_Validators_IdentExists extends Zend_Validate_Abstract
{
    protected $_model;
    protected $_ident;

    public function __construct($model, $ident) {
        $this->_model = $model;
        $this->ident = $ident;
    }

    public function isValid($ident) {
        $elements = Yeah_Adapter::getModel($this->_model);
        $element = $elements->findByIdent($ident);
        if (empty($element)) {
            return false;
        }
        return true;
    }
}
