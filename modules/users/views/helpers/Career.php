<?php

class Users_View_Helper_Career
{
    public function career($id, $name, $value = '') {
        $careers = array ('Lic. Informática', 'Ing. de Sistemas');

        if (empty($id)) {
            $id = $name;
        }

        $options = '';
        foreach ($careers as $career) {
            $selected = '';
            if ($career == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option ' . $selected . ' >' . $career . '</option>'; 
        }

        $select = '<select id="' . $id . '" name="' . $name . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}

