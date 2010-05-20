<?php

class modules_roles_models_Roles extends Zend_Db_Table_Abstract
{
    protected $_name            = 'role';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_roles_models_Roles_Role';
    protected $_dependentTables = array('modules_users_models_Users',
                                        'modules_roles_models_Roles_Privileges',
                                  );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Privilegio',
        'url'                   => 'Identificador',
        'description'           => 'Descripcion',
        'tsregister'            => 'Fecha de registro',
    );

    // Especial method
    public function selectByIncludes($role) {
        // FIXME URGENT URGENT URGENT. logica muy sucia
        global $DB;
        $base = $DB->fetchCol('SELECT privilege FROM role_privilege WHERE role = ' . $role);

        // selection of the others roles
        $rest = $this->fetchAll($this->select()->where('ident <> ?', $role));
        
        $roles = array();
        foreach ($rest as $other) {
            $privileges = $DB->fetchCol('SELECT privilege FROM role_privilege WHERE role = ' . $other->ident);
            $sub = true;
            foreach ($privileges as $privilege) {
                $sub &= in_array($privilege, $base);
            }
            if ($sub) {
                $roles[] = $other;
            }
        }
        return $roles;
    }

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }
}
