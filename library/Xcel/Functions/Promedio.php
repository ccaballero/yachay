<?php

class Xcel_Functions_Promedio
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            $total = Xcel_Syn_Value::add($total, $element);
        }
        return new Xcel_Syn_Value($total->extract() / count($elements));
    }
}
