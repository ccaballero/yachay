<?php

class Yachay_Validators_ReservedWord extends Zend_Validate_Abstract
{
    protected $_reservedWords = array(
        'manager', 'new', 'lock', 'unlock', 'delete', 'import', 'export', 'assign', 'view', 'edit',
    );

    public function isValid($word) {
        if (in_array($word, $this->_reservedWords)) {
            return false;
        }
        return true;
    }
}
