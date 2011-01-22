<?php

class Evaluations_Parser extends Xcel_Parser
{
    public $mode = 'REAL';

    private $_group;
    private $_user;
    private $_evaluation;

    public function Evaluations_Parser ($evaluation) {
        $this->_evaluation = $evaluation;
    }

    public function setGroup($group) {
        $this->_group = $group;
    }

    public function setUser($user) {
        $this->_user = $user;
    }

    public function isVariableValid($variable) {
        if (empty($variable)) {
            return false;
        }
        $model_evaluations_tests = new Evaluations_Test();
        $key = $model_evaluations_tests->findByKey($this->_evaluation, $variable);
        return !empty($key);
    }

    public function fetchValue($variable) {
        if ($this->mode == 'TEST') {
            return new Xcel_Syn_Value(10);
        } else {
            $model_evaluations_tests = new Evaluations_Test();
            $test = $model_evaluations_tests->findByKey($this->_evaluation, $variable);
            $model_califications = new Califications();
            $value = $model_califications->getCalification($this->_group, $this->_user, $this->_evaluation, $test);
            if (empty($value)) {
                $value = $test->defaultnote;
            }
            return new Xcel_Syn_Value($value);
        }
    }
}
