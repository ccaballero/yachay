<?php

class modules_tags_models_Tags_Users extends Zend_Db_Table_Abstract
{
    protected $_name            = 'tag_user';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'modules_tags_models_Tags',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'modules_users_models_Users',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTagAndUser($tag, $user) {
        return $this->fetchRow($this->select()->where('`tag` = ?', $tag)->where('`user` = ?', $user));
    }

    public function deleteUsersInTag($tag) {
        $this->delete('`tag` = ' . $tag);
    }
}
