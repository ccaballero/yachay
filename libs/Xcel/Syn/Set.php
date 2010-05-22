<?php

class Xcel_Syn_Set
{
    public $interpreted = 0;
    private $_elements = array();
    private $_index = 0;

    public function reset() {
        $this->_index = 0;
    }

    public function addElement($value) {
        $this->_elements[] = $value;
    }

    public function getElements() {
        return $this->_elements;
    }
}
