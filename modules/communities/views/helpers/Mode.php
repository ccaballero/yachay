<?php

class Communities_View_Helper_Mode
{
    public function mode($name, $value = '') {
        $modes = array (
            'open'  => 'Publica',
            'close' => 'Privada',
        );
        
        if ($name == null) {
            return $modes[$value];
        }

        $options = '';
        foreach ($modes as $key => $message) {
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
