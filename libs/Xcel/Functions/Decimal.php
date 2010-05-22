<?php

class Xcel_Functions_Decimal
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $neutral = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            $value = $element->extract() - intval($element->extract());
            return new Xcel_Syn_Value(substr($value, 2));
        }
        return $neutral;
    }
}
