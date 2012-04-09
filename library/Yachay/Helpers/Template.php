<?php

class Yachay_Helpers_Template
{
    public function template($module, $script, $type = 'application/', $php = true) {
        global $TEMPLATE;

        $tpl = APPLICATION_PATH . '/modules/' . $module . '/views/scripts/' . $type . $script . '-' . $TEMPLATE->label . '.php';
        if (file_exists($tpl)) {
            return "$script-{$TEMPLATE->label}" . ($php ? '.php' : '');
        }
        return $script . ($php ? '.php' : '');
    }
}
