<?php

class Evaluations_Tests_Values extends Yachay_Db_Table
{
    protected $_name            = 'evaluation_test_value';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Evaluations_Tests_Values_Value';
    protected $_referenceMap    = array(
        'Evaluation'            => array(
            'columns'           => array('evaluation'),
            'refTableClass'     => 'Evaluations',
            'refColumns'        => array('ident'),
        ),
        'Test'                  => array(
            'columns'           => array('test'),
            'refTableClass'     => 'Evaluations_Tests',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByIdent($ident) {
        return $this->fetchRow($this->select()->where('ident = ?', $ident));
    }

    public function findByLabel($label, $test = null) {
        return $this->fetchRow($this->select()->where('test = ?', $test)->where('label = ?', $label));
    }

    public function findByValue($value, $test = null) {
        return $this->fetchRow($this->select()->where('test = ?', $test)->where('value = ?', $value));
    }
}
