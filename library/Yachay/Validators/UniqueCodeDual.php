<?php

class Yachay_Validators_UniqueCodeDual extends Zend_Validate_Abstract
{
    protected $_model;
    protected $_ident;
    protected $_foreign;

    public function __construct($model, $ident, $foreign) {
        $this->_model = $model;
        $this->_ident = $ident;
        $this->_foreign = $foreign;
    }

    public function isValid($value) {
        $model = new $this->_model();
        $element = $model->findByCode($value, $this->_foreign);
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
