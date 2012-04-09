<?php

class Xcel_Functions_Suma
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            $total = Xcel_Syn_Value::add($total, $element);
        }
        return $total;
    }
}
