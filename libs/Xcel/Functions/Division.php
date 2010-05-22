<?php

class Xcel_Functions_Division
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            $total = Xcel_Syn_Value::divide($total, $element);
        }
        return $total;
    }
}
