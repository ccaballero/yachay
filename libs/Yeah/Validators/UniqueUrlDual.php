<?php

class Yeah_Validators_UniqueUrlDual extends Zend_Validate_Abstract
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
        if (is_array($this->_model)) {
            $elements = Yeah_Adapter::getModel($this->_model[0], $this->_model[1]);
        } else {
            $elements = Yeah_Adapter::getModel($this->_model);
        }
        $element = $elements->findByUrl($this->_foreign, $value);
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
