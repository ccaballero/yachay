<?php

class Structures_Tree_Node
{
    private $ident;
    private $parent;
    private $children;

    public function __construct($ident, $parent = null) {
        $this->ident = $ident;
        $this->parent = $parent;
        $this->children = array();
    }

    public function getIdent() {
        return $this->ident;
    }

    public function getParent() {
        return $this->parent;
    }

    public function getChildren() {
        return $this->children;
    }
    
    public function addChild(Structures_Tree_Node $node) {
        $this->children[] = $node;
    }

    public function arrayDown() {
        $array = array($this->ident);

        foreach ($this->children as $child) {
            $array = array_merge($array, $child->arrayDown());
        }

        return $array;
    }

    public function __toString() {
        $string = (string) $this->ident;

        foreach ($this->children as $child) {
            $string .= (string) $child;
        }

        return '(' . $string . ')';
    }
}
