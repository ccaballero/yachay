<?php

class Xcel_Functions_Potencia
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $first = TRUE;
        $elements = $set->getElements();
        foreach ($elements as $element) {
            if ($first) {
                $total = $element;
                $first = FALSE;
            } else {
                $total = new Xcel_Syn_Value(pow($total->extract(), $element->extract()));
            }
        }
        return $total;
    }
}
