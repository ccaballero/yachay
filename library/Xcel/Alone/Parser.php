<?php

class Xcel_Alone_Parser extends Xcel_Parser
{
    public function isVariableValid($variable) {
        return TRUE;
    }

    public function fetchValue($variable) {
        echo 'Ingrese valor para la variable ' . $variable . ' : ';
        $text = $this->getInput(10);
        $text = intval($text);
        return new Xcel_Syn_Value($text);
    }

    private function getInput($length = 255) {
        $fr = fopen("php://stdin","r");
        $input = fgets($fr, $length);
        $input = rtrim($input);
        fclose ($fr);
        return $input;
    }
}
