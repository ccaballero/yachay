<?php

class Xcel_Functions_Proximo
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $point = new Xcel_Syn_Value();
        $resolv = new Xcel_Syn_Value();
        $diff = 65536;

        $first = TRUE;
        $elements = $set->getElements();
        foreach ($elements as $element) {
            if ($first) {
                $point = $element;
                $first = FALSE;
            } else {
                $ratio = abs($element->extract() - $point->extract());
                if ($ratio < $diff) {
                    $diff = $ratio;
                    $resolv = $element;
                }
            }
        }
        return $resolv;
    }
}
