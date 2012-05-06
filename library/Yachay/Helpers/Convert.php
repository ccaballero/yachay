<?php

class Yachay_Helpers_Convert
{
    public function convert($label) {
        $normalize = new Yachay_Helpers_Normalize();
        $label = $normalize->normalize($label);

        $translit = @iconv('UTF-8', 'ASCII//TRANSLIT', $label);
        $search = array('/[^a-z0-9]/', '/--+/', '/^-+/', '/-+$/');
        $replace = array('-', '-', '', '');
        return preg_replace($search, $replace, strtolower($translit));
    }
}
