<?php

class Collections_Tree_Node_Default extends Collections_Tree_Node
{
    public function __construct($ident, $parent = null) {
        $this->_ident = $ident;
        $this->_parent = $parent;

        parent::__construct();
    }
}
