<?php

class Yeah_Helpers_Template
{
    public function template($module, $script, $type = 'application/', $php = true) {
        global $CONFIG;
        global $TEMPLATE;

        $tpl = $CONFIG->dirroot . 'modules/' . $module . '/views/scripts/' . $type . $script . '-' . $TEMPLATE->name . '.php';
        if (file_exists($tpl)) {
            return "$script-{$TEMPLATE->name}" . ($php ? '.php' : '');
        }
        return $script . ($php ? '.php' : '');
    }
}
