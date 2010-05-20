<?php

class Subjects_View_Helper_Visibility
{
    public function visibility($name, $value = '') {
        $visibilities = array (
            'public'   => 'Visible a cualquier persona',
            'register' => 'Visible solo a usuarios registrados',
            'private'  => 'Visible sola a usuarios asignados a la materia',
        );
        
        if ($name == null) {
            return $visibilities[$value];
        }

        $options = '';
        foreach ($visibilities as $key => $message) {
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

