<?php

class Invitations extends Yachay_Model_Table
{
    protected $_name            = 'invitation';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Invitations_Invitation';
    protected $_referenceMap    = array(
        'Author'                => array(
            'columns'           => 'user',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'code'                  => 'Identificador',
        'author'                => 'Autor',
        'email'                 => 'Correo electrónico',
        'accepted'              => 'Aceptado',
        'message'               => 'Mensaje',
        'tsregister'            => 'Fecha de registro',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByCode($code) {
        return $this->fetchRow($this->getAdapter()->quoteInto('code = ?', $code));
    }

    public function findByEmail($email) {
        return $this->fetchRow($this->getAdapter()->quoteInto('email = ?', $email));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select());
    }

    public function selectByAuthor($author) {
        return $this->fetchAll($this->select()->where('author = ?', $author));
    }

    public function selectByAccess($accepted) {
        return $this->fetchAll($this->select()->where('accepted = ?', $accepted));
    }
}
