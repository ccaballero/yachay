<?php

class Xcel_Functions_Maximo
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $maximum = new Xcel_Syn_Value();

        $first = TRUE;
        $elements = $set->getElements();
        foreach ($elements as $element) {
            if ($first) {
                $maximum = $element;
                $first = FALSE;
            } else {
                if ($element->extract() > $maximum->extract()) {
                    $maximum = $element;
                }
            }
        }
        return $maximum;
    }
}
