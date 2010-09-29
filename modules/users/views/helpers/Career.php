<?php

class Users_View_Helper_Career
{
    public function career($name, $value = '') {
        $careers = array ('Lic. Informática', 'Ing. de Sistemas');

        $options = '';
        foreach ($careers as $career) {
            $selected = '';
            if ($career == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option ' . $selected . ' >' . $career . '</option>'; 
        }

        $select = '<select name="' . $name . '" id="' . $name . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}

