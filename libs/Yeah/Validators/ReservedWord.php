<?php

class Yeah_Validators_ReservedWord extends Zend_Validate_Abstract
{
    protected $_reservedWords = array('manager');

    public function isValid($word) {
        if (in_array($word, $this->_reservedWords)) {
            return false;
        }
        return true;
    }
}
