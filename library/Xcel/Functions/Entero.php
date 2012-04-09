<?php

class Xcel_Functions_Entero
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $neutral = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            return new Xcel_Syn_Value(intval($element->extract()));
        }
        return $neutral;
    }
}
