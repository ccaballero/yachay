<?php

class Packages_Package extends Collections_Tree_Node_Default
{
    public $ident;
    public $label;
    public $url;
    public $status;
    public $type;
    public $description;
    public $tsregister;
    public $parent;

    public function ident() {
        return $this->url;
    }

    public function parent() {
        return $this->parent;
    }
}
