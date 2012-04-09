<?php

class Xcel_Functions_Modulo
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $total = new Xcel_Syn_Value();

        $elements = $set->getElements();
        foreach ($elements as $element) {
            $total = Xcel_Syn_Value::residue($total, $element);
        }
        return $total;
    }
}
