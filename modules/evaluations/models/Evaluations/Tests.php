<?php

class modules_evaluations_models_Evaluations_Tests extends Zend_Db_Table_Abstract
{
    protected $_name            = 'evaluation_test';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'modules_evaluations_models_Evaluations_Tests_Test';
    protected $_dependentTables = array('modules_evaluations_models_Evaluations_Tests_Values',
                                  );
    protected $_referenceMap    = array(
        'Evaluation'            => array(
            'columns'           => array('evaluation'),
            'refTableClass'     => 'modules_evaluations_models_Evaluations',
            'refColumns'        => array('ident'),
        ),
    );

	public function findByIdent($ident) {
        return $this->fetchRow($this->select()
                                    ->where('ident = ?', $ident));
    }

    public function findByLabel($evaluation, $label) {
        return $this->fetchRow($this->select()
                                    ->where('evaluation = ?', $evaluation)
                                    ->where('label = ?', $label));
    }

    public function findByKey($evaluation, $key) {
        return $this->fetchRow($this->select()
                                    ->where('evaluation = ?', $evaluation)
                                    ->where('`key` = ?', $key));
    }
}
