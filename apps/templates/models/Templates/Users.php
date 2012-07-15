<?php

class Templates_Users extends Yachay_Db_Table
{
    protected $_name            = 'template_user';
    protected $_referenceMap    = array(
        'Template'              => array(
            'columns'           => array('template'),
            'refTableClass'     => 'Templates',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTemplateAndUser($template, $user) {
        return $this->fetchRow($this->select()->where('`template` = ?', $template)->where('`user` = ?', $user));
    }
}
