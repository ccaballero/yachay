<?php

class Yeah_Helpers_Template
{
    public function template($module, $script, $type = 'application/') {
        global $CONFIG;
        global $THEME;

        $tpl = $CONFIG->dirroot . 'modules/' . $module . '/views/scripts/' . $type . $script . '.' . $THEME->name . '.php';
        if (file_exists($tpl)) {
            return "$script.{$THEME->name}.php";
        }
        return "$script.php";
    }
}
