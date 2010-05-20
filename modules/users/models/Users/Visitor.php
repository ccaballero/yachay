<?php

class modules_users_models_Users_Visitor
{
    public $ident = 0;
    public $role = 1;
    public $_acl = array();

    public function modules_users_models_Users_Visitor() {
        $roles = Yeah_Adapter::getModel('roles');
        $visitor = $roles->findByIdent($this->role);

        $privileges = $visitor->findManyToManyRowset('modules_privileges_models_Privileges', 'modules_roles_models_Roles_Privileges');
        foreach ($privileges as $privilege) {
            $this->_acl[] = $privilege->module . '_' . $privilege->privilege;
        }
    }

    public function hasPermission($module, $privilege) {
        return in_array($module . '_' . $privilege, $this->_acl);
    }
}
