<?php

class Xcel_Functions_Semilla
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $elements = $set->getElements();
        if (count($elements) == 1) {
            if ($elements[0]->extract() == 0) {
                return new Xcel_Syn_Value();
            } else {
                return $elements[0];
            }
        }
        $index = rand(0, count($elements) - 1);
        return $elements[$index];
    }
}
