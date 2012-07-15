<?php

class Resources_Globales extends Yachay_Db_Table
{
    protected $_name            = 'resource_global';
    protected $_referenceMap    = array(
        'Resource'              => array(
            'columns'           => array('resource'),
            'refTableClass'     => 'Resources',
            'refColumns'        => array('ident'),
        ),
    );

    public function selectAll() {
        return $this->fetchAll($this->select());
    }
}
