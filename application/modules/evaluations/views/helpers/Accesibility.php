<?php

class Evaluations_View_Helper_Accesibility
{
    public function accesibility($name, $value = '') {
        $values = array (
            'public'   => 'Publica - Compartido a otros usuarios',
            'private'  => 'Privada - Uso personal',
        );
        
        if ($name == null) {
            return $values[$value];
        }

        $options = '';
        foreach ($values as $key => $message) {
            $selected = '';
            if ($key == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option value="' . $key . '"' . $selected . ' >' . $message . '</option>'; 
        }

        $select = '<select name="' . $name . '" id="' . $name . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
