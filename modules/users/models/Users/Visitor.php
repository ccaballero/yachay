<?php

class Users_Visitor
{
    public $ident = 0;
    public $role = 1;
    public $_acl = array();

    public function Users_Visitor() {
        $model_roles = new Roles();
        $visitor = $model_roles->findByIdent($this->role);

        $privileges = $visitor->findPrivilegesViaRoles_Privileges();
        foreach ($privileges as $privilege) {
            $this->_acl[] = $privilege->module . '_' . $privilege->privilege;
        }
    }

    public function hasPermission($module, $privilege) {
        return in_array($module . '_' . $privilege, $this->_acl);
    }
}
