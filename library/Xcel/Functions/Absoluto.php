<?php

class Xcel_Functions_Absoluto
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $neutral = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            if ($element->extract() >= 0) {
                return $element;
            } else {
                return Xcel_Syn_Value::multiply($element, new Xcel_Syn_Value(-1));    
            }
        }
        return $neutral;
	}
}
