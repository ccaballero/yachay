<?php

class modules_roles_models_Roles_Privileges extends Zend_Db_Table_Abstract
{
    protected $_name            = 'role_privilege';
    protected $_referenceMap    = array(
        'Role'                  => array(
            'columns'           => array('role'),
            'refTableClass'     => 'modules_roles_models_Roles',
            'refColumns'        => array('ident'),
        ),
        'Privilege'             => array(
            'columns'           => array('privilege'),
            'refTableClass'     => 'modules_privileges_models_Privileges',
            'refColumns'        => array('ident'),
        ),
    );

    public function deletePrivilegesInRole($role) {
        $this->delete('role = ' . $role);
    }
}
