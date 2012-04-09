<?php

class Evaluations_Sandbox_Parser extends Xcel_Parser
{
    public function isVariableValid($variable) {
        return TRUE;
    }

    public function fetchValue($variable) {
        $text = '0';
        $text = floatval($text);
        return new Xcel_Syn_Value($text);
    }
}
