<?php

class Xcel_Functions_Escala
{
    public function getValue(Xcel_Syn_Set $set = null) {
        $note = new Xcel_Syn_Value();

        $elements = $set->getElements();
        if (count($elements) == 5) {
            $point   = $elements[0]->extract();
            $min_old = $elements[1]->extract();
            $max_old = $elements[2]->extract();
            $min_new = $elements[3]->extract();
            $max_new = $elements[4]->extract();

            return new Xcel_Syn_Value($min_new + ($point * ($max_new - $min_new) / ($max_old - $min_old)));
        }
        
        return $note;
    }
}
