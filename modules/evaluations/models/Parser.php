<?php

class modules_evaluations_models_Parser extends Xcel_Parser
{
    public $mode = 'REAL';

    private $_group;
    private $_user;
    private $_evaluation;

    public function modules_evaluations_models_Parser ($evaluation) {
        $this->_evaluation = $evaluation;
    }

    public function setGroup($group) {    $this->_group = $group; }
    public function setUser($user) {      $this->_user = $user; }

    public function isVariableValid($variable) {
        if (empty($variable)) {
            return false;
        }
        $tests = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
        $key = $tests->findByKey($this->_evaluation, $variable);
        return !empty($key);
    }

    public function fetchValue($variable) {
        if ($this->mode == 'TEST') {
            return new Xcel_Syn_Value(10);
        } else {
            $tests = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
            $test = $tests->findByKey($this->_evaluation, $variable);
            $califications = Yeah_Adapter::getModel('califications');
            $value = $califications->getCalification($this->_group, $this->_user, $this->_evaluation, $test);
            if (empty($value)) {
                $value = $test->defaultnote;
            }
            return new Xcel_Syn_Value($value);
        }
    }
}
