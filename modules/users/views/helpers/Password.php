<?php

class Users_View_Helper_Password
{
    public function password($id, $name, $value = '') {
        $generators = array (
            '' => '----------',
            'alphanum' => 'Aleatoria',
            '.code.'   => '.[Codigo].',
            '.edoc.'   => '.[Codigo Invertido].',
        );

        if ($name == null) {
            return $generators[$value];
        }
        if (empty($id)) {
            $id = $name;
        }

        $options = '';
        foreach ($generators as $key => $message) {
            $selected = '';
            if ($key == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option value="' . $key . '"' . $selected . ' >' . $message . '</option>'; 
        }

        $select = '<select id="' . $id . '" name="' . $name . '">' . $options . '</select>';
        return $select;
    }
}
