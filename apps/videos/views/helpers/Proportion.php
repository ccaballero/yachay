<?php

class Videos_View_Helper_Proportion
{
    public function proportion($id, $name, $value = '') {
        $generators = array (
            '1:1' => '1:1',
            '4:3' => '4:3',
            '16:9' => '16:9',
            '16:10' => '16:10',
            '2.21:1' => '2.21:1',
            '5:4' => '5:4',
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
