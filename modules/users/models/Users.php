<?php

class modules_users_models_Users extends Zend_Db_Table_Abstract
{
    protected $_name            = 'user';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_users_models_Users_User';
    protected $_dependentTables = array('modules_roles_models_Roles',
                                        'modules_subjects_models_Subjects_Users',
                                        'modules_groups_models_Groups_Users',
                                        'modules_teams_models_Teams_Users',
                                        'modules_subjects_models_Subjects',
                                        'modules_groupsets_models_Groupsets',
                                        'modules_groups_models_Groups',
                                        'modules_teams_models_Teams',
                                        'modules_resources_models_Resources',
                                        'modules_users_models_Users_Resources',
                                        'modules_communities_models_Communities',
                                        'modules_communities_models_Communities_Users',
                                        'modules_communities_models_Communities_Petitions',
                                        'modules_comments_models_Comments',
                                        'modules_evaluations_models_Evaluations',
                                        'modules_invitations_models_Invitations',
                                  );
    protected $_referenceMap    = array(
        'Role'                  => array(
            'columns'           => 'role',
            'refTableClass'     => 'modules_roles_models_Roles',
            'refColumns'        => 'ident',
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
        'interests'             => 'Intereses',
        'description'           => 'Descripción',
        'sign'                  => 'Firma',
        'activity'              => 'Actividad',
        'participation'         => 'Participación',
        'sociability'           => 'Sociabilidad',
        'knowledge'             => 'Conocimiento',
        'popularity'            => 'Popularidad',
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
        return $this->fetchAll($this->select()->order('role DESC')->order('label ASC'));
    }

    public function selectByRole($role) {
        return $this->fetchAll($this->select()->where('role = ?', $role));
    }

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status)->order('role DESC')->order('label ASC'));
    }
}
