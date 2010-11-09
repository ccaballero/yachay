<?php

class Subjects_View_Helper_Visibility
{
    public function visibility($id, $name, $value = '') {
        $visibilities = array (
            'public'   => 'Cualquier persona',
            'register' => 'Usuarios registrados',
            'private'  => 'Usuarios asignados a la materia',
        );
        
        if ($name == null) {
            return $visibilities[$value];
        } else {
            if (empty($id)) {
                $id = $name;
            }
        }

        $options = '';
        foreach ($visibilities as $key => $message) {
            $selected = '';
            if ($key == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option value="' . $key . '"' . $selected . ' >' . $message . '</option>'; 
        }

        $select = '<select id="' . $id . '" name="' . $name . '" id="' . $name . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}

