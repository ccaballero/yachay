<?php

class Tags_Users extends Yachay_Models_Table
{
    protected $_name            = 'tag_user';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'Tags',
            'refColumns'        => array('ident'),
        ),
        'User'                  => array(
            'columns'           => array('user'),
            'refTableClass'     => 'Users',
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
