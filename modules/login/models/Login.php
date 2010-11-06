<?php

class Login extends Yeah_Model_Table
{
    protected $_name            = 'login_forgot';
    protected $_primary         = 'ident';
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => 'user',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'user'                  => 'Usuario',
        'password'              => 'Contraseña',
        'tsregister'            => 'Fecha de Registro',
        'tstimeout'             => 'Expiracion',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByUser($user) {
        return $this->fetchRow($this->select()->where('user = ?', $user));
    }
}
