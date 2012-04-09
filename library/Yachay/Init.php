<?php

class Yachay_Init
{
    public $routes = array();
    public $check  = array();
    
    public function setRoutes($router) {
        foreach ($this->routes as $key => $route) {
            $router->addRoute($key, new Zend_Controller_Router_Route($route[0], $route[1]));
        }
    }
}
