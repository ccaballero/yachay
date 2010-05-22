<?php

class Yeah_Validators_HasPrivilege extends Zend_Validate_Abstract
{
    protected $_module;
    protected $_privilege;
    protected $_ident;

    public function __construct($module, $privilege, $ident) {
        $this->_module = $module;
        $this->_privilege = $privilege;
        $this->_ident = $ident;
    }

    public function isValid($ident) {
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByIdent($ident);
        if ($user->hasPermission($this->_module, $this->_privilege)) {
            return true;
        }
        return false;
    }
}
