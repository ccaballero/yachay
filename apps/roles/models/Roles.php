<?php

class Roles extends Yachay_Db_Table
{
    protected $_name            = 'role';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Roles_Role';
    protected $_dependentTables = array('Users', 'Roles_Privileges', );
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
        $db = Zend_Db_Table::getDefaultAdapter();
        $base = $db->fetchCol('SELECT privilege FROM role_privilege WHERE role = ' . $role);

        // selection of the others roles
        $rest = $this->fetchAll($this->select()->where('ident <> ?', $role));
        
        $roles = array();
        foreach ($rest as $other) {
            $privileges = $db->fetchCol('SELECT privilege FROM role_privilege WHERE role = ' . $other->ident);
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
