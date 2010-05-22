<?php

class Xcel_Functions_Random
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $first = TRUE;
        $elements = $set->getElements();

        if (count($elements) == 0) {
            return new Xcel_Syn_Value(rand(0, 10000) / 10000);
        } else if (count($elements) == 1) {
            $value = $elements[0]->extract();
            if ($value == 0) {
                return new Xcel_Syn_Value(rand(0, 10000) / 10000);
            } else {
                return new Xcel_Syn_Value(rand(0, $value));
            }
        } else {
            $value1 = $elements[0]->extract();
            $value2 = $elements[1]->extract();
            return new Xcel_Syn_Value(rand($value1 < $value2 ? $value1 : $value2, $value1 > $value2 ? $value1 : $value2));
        }

        return $total;
    }
}
