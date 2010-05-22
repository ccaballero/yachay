<?php

class Yeah_Helpers_Interval
{
    public function interval($name1, $name2, $value = 'day') {
        $ds = '';
        if (is_int($value)) {
             $ts = intval($value);
             if ($ts % 2592000 == 0) {
                 $ds = $ts / 2592000;
                 $is = 'month';
             } else if ($ts % 604800 == 0) {
                 $ds = $ts / 604800;
                 $is = 'week';
             } else if ($ts % 86400 == 0) {
                 $ds = $ts / 86400;
                 $is = 'day';
             } else if ($ts % 3600 == 0) {
                 $ds = $ts / 3600;
                 $is = 'hour';
             } else if ($ts % 60 == 0) {
                 $ds = $ts / 60;
                 $is = 'minute';
             }
             $value = $is;
        }

        $duration = '<input type="text" name="' . $name1 . '" size="3" maxlength="5" value="' . $ds . '" />';

        $interval = array (
        	'minute' => 'Minutos',
            'hour' => 'Horas',
            'day' => 'Dias',
            'week' => 'Semanas',
            'month' => 'Meses',
        );

        $options = '';
        foreach ($interval as $key => $label) {
            $selected = '';
            if ($key == $value) {
                $selected = ' selected="selected"';
            }
            $options .= '<option value="' . $key . '"' . $selected . '>' . $label . '</option>'; 
        }

        $select = '<select name="' . $name2 . '" id="' . $name2 . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';

        return $duration . $select;
    }
}
