<?php

class Structures_Tree_Node
{
    private $ident;
    private $children;

    public function __construct($ident) {
        $this->ident = $ident;
        $this->children = array();
    }

    public function getIdent() {
        return $this->ident;
    }

    public function getChildren() {
        return $this->children;
    }
    
    public function addChild(Structures_Tree_Node $node) {
        $this->children[] = $node;
    }

    public function __toString() {
        $string = (string) $this->ident;

        foreach ($this->children as $child) {
            $string .= (string) $child;
        }

        return '(' . $string . ')';
    }
}
