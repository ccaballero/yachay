<?php

class Users extends Yachay_Model_Table
{
    protected $_name            = 'user';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Users_User';
    protected $_dependentTables = array('Roles',
                                        'Subjects', 'Subjects_Users',
                                        'Groups', 'Groups_Users',
                                        'Teams', 'Teams_Users',
                                        'Resources', 'Users_Resources',
                                        'Communities', 'Communities_Users', 'Communities_Petitions',
                                        'Groupsets',
                                        'Comments', 'Tags_Users',
                                        'Evaluations',
                                  );
    protected $_referenceMap    = array(
        'Role'                  => array(
            'columns'           => 'role',
            'refTableClass'     => 'Roles',
            'refColumns'        => 'ident',
        ),
        'Theme'                 => array(
            'columns'           => 'theme',
            'refTableClass'     => 'Themes',
            'refColumns'        => 'label',
        ),
    );
    public    $_mapping         = array(
        'ident'                 => 'Código',
        'role'                  => 'Rol',                   // required
        'code'                  => 'Código',                // required
        'label'                 => 'Usuario',                           // optional
        'url'                   => 'Identificador',
        'email'                 => 'Correo electrónico',                // optional
        'status'                => 'Estado',
        'formalname'            => 'Nombre Completo',       // required
        'surname'               => 'Apellidos',                         // optional
        'name'                  => 'Nombres',                           // optional
        'avatar'                => 'Tiene avatar',
        'birdthdate'            => 'Fecha de nacimiento',
        'career'                => 'Carrera',                           // optional
        'phone'                 => 'Teléfono',                          // optional
        'cellphone'             => 'Celular',                           // optional
        'hobbies'               => 'Pasatiempos',
        'description'           => 'Descripción',
        'sign'                  => 'Firma',
        'activity'              => 'Actividad',
        'participation'         => 'Participación',
        'sociability'           => 'Sociabilidad',
        'popularity'            => 'Popularidad',
        'knowledge'             => 'Conocimiento',
        'tsregister'            => 'Fecha de registro',
        'tslastlogin'           => 'Último acceso',
    );

    // Especial method
    public function findByLogin($label, $password) {
        return $this->fetchRow($this->select()->where('label = ?', $label)->where('password = ?', $password));
    }

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByCode($code) {
        return $this->fetchRow($this->getAdapter()->quoteInto('code = ?', $code));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    public function findByEmail($email) {
        return $this->fetchRow($this->getAdapter()->quoteInto('email = ?', $email));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('surname ASC')->order('name ASC'));
    }

    public function selectByRole($role) {
        return $this->fetchAll($this->select()->where('role = ?', $role)->order('surname ASC')->order('name ASC'));
    }

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status)->order('(popularity + activity + participation + sociability) DESC'));
    }
}
