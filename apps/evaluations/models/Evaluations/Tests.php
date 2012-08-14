<?php

class Evaluations_Tests extends Yachay_Db_Table
{
    protected $_name            = 'evaluation_test';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Evaluations_Tests_Test';
    protected $_dependentTables = array('Evaluations_Tests_Values');
    protected $_referenceMap    = array(
        'Evaluation'            => array(
            'columns'           => array('evaluation'),
            'refTableClass'     => 'Evaluations',
            'refColumns'        => array('ident'),
        ),
    );

    public function findByIdent($ident) {
        return $this->fetchRow($this->select()->where('ident = ?', $ident));
    }

    public function findByLabel($label, $evaluation = null) {
        return $this->fetchRow($this->select()->where('evaluation = ?', $evaluation)->where('label = ?', $label));
    }

    public function findByKey($key, $evaluation = null) {
        return $this->fetchRow($this->select()->where('`evaluation` = ?', $evaluation)->where('`key` = ?', $key));
    }
}
