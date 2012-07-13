<?php

class Collections_Tree_Node_Default implements Collections_Tree_Structurable
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
