<?php

class Yeah_Loader implements Zend_Loader_Autoloader_Interface
{
    public function autoload($class) {
        global $CONFIG;

        $position = strpos($class, '_');
        if (empty($position)) {
            $dir = strtolower($class);
        } else {
            $dir = strtolower(substr($class, 0, $position));
        }
        Zend_Loader::loadClass($class, $CONFIG->dirroot . 'modules/' . $dir . '/models');
    }
}
