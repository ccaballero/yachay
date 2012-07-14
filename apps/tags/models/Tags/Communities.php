<?php

class Tags_Communities extends Yachay_Model_Table
{
    protected $_name            = 'tag_community';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'Tags',
            'refColumns'        => array('ident'),
        ),
        'Community'             => array(
            'columns'           => array('community'),
            'refTableClass'     => 'Communities',
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
