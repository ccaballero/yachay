<?php

class Yachay_Validators_EmailAddressOrNull extends Zend_Validate_Abstract
{
    public function isValid($value) {
        if (empty($value)) {
            return true; // About of nullity for email
        } else {
            $validator = new Zend_Validate_EmailAddress;
            return $validator->isValid($value);
        }
    }
}
