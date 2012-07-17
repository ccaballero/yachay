<?php

class Routes_Route extends Collections_Tree_Node_Default
{
    public $ident;
    public $label;
    public $type;
    public $route;
    public $mapping;
    public $module;
    public $controller;
    public $action;
    public $parent;

    public function ident() {
        return $this->route;
    }

    public function parent() {
        return $this->parent;
    }
}
