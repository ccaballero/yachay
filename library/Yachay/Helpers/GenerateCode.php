<?php

class Yachay_Helpers_GenerateCode
{
    public function generateCode($type = 'alphanum', $code = NULL, $size = 16) {
        if ($type == 'alphanum') {
            $values = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
            $length = strlen($values);
            $code = '';
            for ($i = 0; $i < $size; $i++) {
                $code .= $values[rand(0, $length - 1)];
            }
            return $code;
        }
        if ($type == '.code.') {
            return ".$code.";
        }
        if ($type == '.edoc.') {
            $code = strrev($code);
            return ".$code.";
        }
    }
}
