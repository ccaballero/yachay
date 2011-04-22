<?php

class Yeah_Helpers_Time
{
    // modes: { 'BEFORE', 'AFTER', 'BOTH'}
    public function time($name, $value = '0-0-0-0-0', $mode = 'BOTH') {
        if (empty($value)) {
            $value = '0-0-0-0-0';
        }
        if (is_int($value)) {
            $value = date('Y-n-j-H-i', $value);
        }
        list($Year, $Month, $Day, $Hour, $Minute) = @split('[/.-]', $value);

        // generacion del dia
        $day = '<select name="' . $name . '-day" id="' . $name . '-day"><option value="-1">D&iacute;a:</option>';
        for ($i = 1; $i <= 31; $i++) {
            $selected = '';
            if ($Day == $i) {
                $selected = 'selected="selected" ';
            }
            if ($i < 10) {
                $day .= '<option ' . $selected . 'value="0' . $i . '">' . $i . '</option>';
            } else {
                $day .= '<option ' . $selected . 'value="' . $i . '">' . $i . '</option>';
            }
        }
        $day .= '</select>';

        // generacion del mes
        $months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $month = '<select name="' . $name . '-month" id="' . $name . '-month"><option value="-1">Mes:</option>';
        for ($j = 1; $j <= count($months); $j++) {
            $selected = '';
            if ($Month == $j) {
                $selected = 'selected="selected" ';
            }
            if ($j < 10) {
                $month .= '<option ' . $selected . 'value="0' . $j . '">' . $months[$j - 1] . '</option>';
            } else {
                $month .= '<option ' . $selected . 'value="' . $j . '">' . $months[$j - 1] . '</option>';
            }
        }
        $month .= '</select>';

        // generacion del año
        $year = '<select name="' . $name . '-year" id="' . $name . '-year"><option value="-1">Año: </option>';
        $current_year = date("Y");

        switch ($mode) {
            case 'BEFORE':
                $start_year = $current_year - 100;
                $end_year = $current_year;
                break;
            case 'AFTER':
                $start_year = $current_year;
                $end_year = $current_year + 20;
                break;
            case 'BOTH':
                $start_year = $current_year - 100;
                $end_year = $current_year + 20;
                break;
        }

        for ($k = $end_year; $k >= $start_year; $k--) {
            $selected = '';
            if ($Year == $k) {
                $selected = 'selected="selected" ';
            }
            $year .= '<option ' . $selected . 'value="' . $k . '">' . $k . '</option>';
        }
        $year .= '</select>';

        // generacion de la hora
        $hour = '<select name="' . $name . '-hour" id="' . $name . '-hour"><option value="-1">Hora:</option>';
        for ($k = 0; $k < 24; $k++) {
            $selected = '';
            if ($Hour == $k) {
                $selected = 'selected="selected" ';
            }
            $hour .= '<option ' . $selected . 'value="' . $k . '">' . $k . '</option>';
        }
        $hour .= '</select>';

        // generacion del minuto
        $minute = '<select name="' . $name . '-minute" id="' . $name . '-minute"><option value="-1">Minuto:</option>';
        for ($k = 0; $k < 60; $k++) {
            $selected = '';
            if ($Minute == $k) {
                $selected = 'selected="selected" ';
            }
            $minute .= '<option ' . $selected . 'value="' . $k . '">' . $k . '</option>';
        }
        $minute.= '</select>';

        return $day . $month . $year . '&nbsp;' . $hour . ':' . $minute;
    }
}
