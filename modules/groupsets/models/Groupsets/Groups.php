<?php

class Groupsets_Groups extends Yeah_Model_Table
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
        global $DB;
        $select = $DB->select()->from('groupset_group')->where('groupset = ?' , $groupset);
        $result = $DB->fetchAll($select);
        return $result;
    }
}
