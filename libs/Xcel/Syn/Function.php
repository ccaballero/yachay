<?php

class Xcel_Syn_Function
{
    public static function isFunctionValid($function) {
        global $CONFIG;
        $function = ucfirst(strtolower(trim($function)));
        if (file_exists($CONFIG->dirroot . 'libs/Xcel/Functions/' . $function . '.php')) {
            return TRUE;
        }
        return FALSE;
	}

    public static function fetchFunction($function) {
        $function = ucfirst(strtolower(trim($function)));
        $function = 'Xcel_Functions_' . $function;
        $model = new $function();
        return $model;
    }
}
