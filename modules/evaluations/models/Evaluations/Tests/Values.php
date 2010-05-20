<?php

class modules_evaluations_models_Evaluations_Tests_Values extends Zend_Db_Table_Abstract
{
    protected $_name            = 'evaluation_test_value';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_evaluations_models_Evaluations_Tests_Values_Value';
    protected $_referenceMap    = array(
        'Evaluation'            => array(
            'columns'           => array('evaluation'),
            'refTableClass'     => 'modules_evaluations_models_Evaluations',
            'refColumns'        => array('ident'),
        ),
        'Test'                  => array(
            'columns'           => array('test'),
            'refTableClass'     => 'modules_evaluations_models_Evaluations_Tests',
            'refColumns'        => array('ident'),
        ),
    );

	public function findByIdent($ident) {
        return $this->fetchRow($this->select()
                                    ->where('ident = ?', $ident));
    }

    public function findByLabel($test, $label) {
        return $this->fetchRow($this->select()
                                    ->where('test = ?', $test)
                                    ->where('label = ?', $label));
    }

    public function findByValue($test, $value) {
        return $this->fetchRow($this->select()
                                    ->where('test = ?', $test)
                                    ->where('value = ?', $value));
    }
}
