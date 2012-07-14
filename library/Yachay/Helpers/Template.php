<?php

class Yachay_Helpers_Template
{
    public function template($package, $script, $type = 'application/', $php = true) {
        $config = Zend_Registry::get('config');
        $template = Zend_Registry::get('template');

        $tpl = $config->resources->frontController->moduleDirectory . '/' . $package . '/views/scripts/' . $type . $script . '-' . $template->label . '.php';
        if (file_exists($tpl)) {
            return "$script-{$template->label}" . ($php ? '.php' : '');
        }
        return $script . ($php ? '.php' : '');
    }
}
