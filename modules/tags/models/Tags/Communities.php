<?php

class modules_tags_models_Tags_Communities extends Zend_Db_Table_Abstract
{
    protected $_name            = 'tag_community';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'modules_tags_models_Tags',
            'refColumns'        => array('ident'),
        ),
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'modules_communities_models_Communities',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTagAndCommunity($tag, $community) {
        return $this->fetchRow($this->select()->where('`tag` = ?', $tag)->where('`community` = ?', $community));
    }

    public function deleteCommunitiesInTag($tag) {
        $this->delete('`tag` = ' . $tag);
    }
}
