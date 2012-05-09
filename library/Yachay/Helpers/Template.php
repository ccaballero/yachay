<?php

class Yachay_Helpers_Template
{
    public function template($module, $script, $type = 'application/', $php = true) {
        $template = Zend_Registry::get('template');

        $tpl = APPLICATION_PATH . '/modules/' . $module . '/views/scripts/' . $type . $script . '-' . $template->label . '.php';
        if (file_exists($tpl)) {
            return "$script-{$template->label}" . ($php ? '.php' : '');
        }
        return $script . ($php ? '.php' : '');
    }
}
