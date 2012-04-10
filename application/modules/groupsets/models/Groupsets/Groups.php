<?php

class Groupsets_Groups extends Yachay_Models_Table
{
    protected $_name            = 'groupset_group';
    protected $_referenceMap    = array(
        'Groupset'              => array(
            'columns'           => array('groupset'),
            'refTableClass'     => 'Groupsets',
            'refColumns'        => array('ident'),
        ),
        'Group'                 => array(
            'columns'           => array('group'),
            'refTableClass'     => 'Groups',
            'refColumns'        => array('ident'),
        ),
    );

    public function selectByGroupset($groupset) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()->from('groupset_group')->where('groupset = ?' , $groupset);
        $result = $db->fetchAll($select);
        return $result;
    }
}
