<?php

class Yachay_Validators_HasPrivilege extends Zend_Validate_Abstract
{
    protected $_package;
    protected $_label;
    protected $_ident;

    public function __construct($package, $label, $ident) {
        $this->_package = $package;
        $this->_label = $label;
        $this->_ident = $ident;
    }

    public function isValid($ident) {
        $model_users = new Users();
        $user = $model_users->findByIdent($ident);
        if ($user->hasPermission($this->_package, $this->_label)) {
            return true;
        }
        return false;
    }
}
