<?php

class modules_login_models_Login extends Zend_Db_Table_Abstract
{
    protected $_name            = 'login_forgot';
    protected $_primary         = 'ident';
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => 'user',
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'user'                  => 'Usuario',
        'password'              => 'Contrase&ntilde;a',
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
