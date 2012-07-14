<?php

class Yachay_Loader implements Zend_Loader_Autoloader_Interface
{
    private $default = 'models';
    private $namespaces = array(
        'Db' => 'adapters',
    );

    public function autoload($class) {
        $list = explode('_', $class);

        if (array_key_exists($list[0], $this->namespaces)) {
            $namespace = array_shift($list);
            $subdir = $this->namespaces[$namespace];
        } else {
            $subdir = $this->default;
        }

        $package = strtolower($list[0]);
        $file = array_pop($list) . '.php';
        $dir = $package . '/' . $subdir . '/' . implode('/', $list);

        Zend_Loader::loadFile($file, APPLICATION_PATH . '/packages/' . $dir, true);
    }
}
