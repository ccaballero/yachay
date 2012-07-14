<?php

class Roles_Privileges extends Yachay_Model_Table
{
    protected $_name            = 'role_privilege';
    protected $_referenceMap    = array(
        'Role'                  => array(
            'columns'           => array('role'),
            'refTableClass'     => 'Roles',
            'refColumns'        => array('ident'),
        ),
        'Privilege'             => array(
            'columns'           => array('privilege'),
            'refTableClass'     => 'Privileges',
            'refColumns'        => array('ident'),
        ),
    );

    public function deletePrivilegesInRole($role) {
        $this->delete('role = ' . $role);
    }
}
