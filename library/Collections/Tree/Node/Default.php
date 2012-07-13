<?php

class Structures_Tree_Node_Default implements Structures_Tree_Structurable
{
    public $ident;
    public $parent = null;

    public function __construct($ident, $parent = null) {
        $this->ident = $ident;
        $this->parent = $parent;
    }

    public function getIdent() {
        return $this->ident;
    }

    public function getParent() {
        return $this->parent;
    }
}
