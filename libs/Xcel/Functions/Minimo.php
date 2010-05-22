<?php

class Xcel_Functions_Minimo
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $minimum = new Xcel_Syn_Value();

        $first = TRUE;
        $elements = $set->getElements();
        foreach ($elements as $element) {
            if ($first) {
                $minimum = $element;
                $first = FALSE;
            } else {
                if ($element->extract() < $minimum->extract()) {
                    $minimum = $element;
                }
            }
        }
        return $minimum;
    }
}
