<?php

class Tags_Resources extends Yachay_Models_Table
{
    protected $_name            = 'tag_resource';
    protected $_referenceMap    = array(
        'Tag'                   => array(
            'columns'           => array('tag'),
            'refTableClass'     => 'Tags',
            'refColumns'        => array('ident'),
        ),
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByTagAndResource($tag, $resource) {
        return $this->fetchRow($this->select()->where('`tag` = ?', $tag)->where('`resource` = ?', $resource));
    }

    public function deleteResourcesInTag($tag) {
        $this->delete('`tag` = ' . $tag);
    }
}
