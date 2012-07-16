<?php

class Users_Visitor
{
    public $ident = 0;
    public $role = 1;
    public $_acl = array();

    public $template = '';

    public function Users_Visitor() {
        $model_roles = new Roles();
        $visitor = $model_roles->findByIdent($this->role);

        $privileges = $visitor->findPrivilegesViaRoles_Privileges();
        foreach ($privileges as $privilege) {
            $this->_acl[] = $privilege->package . '_' . $privilege->label;
        }

        $config = Zend_Registry::get('config');
        $this->template = $config->resources->layout->layout;
    }

    public function hasPermission($package, $label) {
        return in_array($package . '_' . $label, $this->_acl);
    }

    public function lastLogin() {}
    public function needFillProfile() {
        return false;
    }
}
