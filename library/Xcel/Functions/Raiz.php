<?php

class Xcel_Functions_Raiz
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $first = TRUE;
        $elements = $set->getElements();
        if (count($elements) == 1) {
            return new Xcel_Syn_Value(sqrt($elements[0]->extract()));
        }

        foreach ($elements as $element) {
            if ($first) {
                $total = $element;
                $first = FALSE;
            } else {
                $total = new Xcel_Syn_Value(pow($total->extract(), (1 / $element->extract())));
            }
        }
        return $total;
    }
}
