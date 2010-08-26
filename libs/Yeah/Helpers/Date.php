<?php

class Yeah_Helpers_Date
{
    public function date($name, $value = '0-0-0') {
        if (empty($value)) {
            $value = '0-0-0';
        }
        list($Year, $Month, $Day) = @split('[/.-]', $value);

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
        $year = '<select name="' . $name . '-year" id="' . $name . '-year"><option value="-1">A&ntilde;o:</option>';
        for ($k = 2009; $k >= 1900; $k--) {
            $selected = '';
            if ($Year == $k) {
                $selected = 'selected="selected" ';
            }
            $year .= '<option ' . $selected . 'value="' . $k . '">' . $k . '</option>';
        }
        $year .= '</select>';

        return $day . $month . $year;
    }
}
