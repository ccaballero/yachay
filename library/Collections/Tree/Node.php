<?php

abstract class Collections_Tree_Node implements Collections_Tree_Nodeable, Iterator
{
    protected $_ident;
    protected $_parent;

    protected $_children;

    public function __construct() {
        $this->_children = array();
        $this->_level = 0;
    }

    public function ident() {
        if (empty($this->_ident)) {
            throw new Exception('Node is used without ident');
        }

        return $this->_ident;
    }

    public function parent() {
        return $this->_parent;
    }

    public function children() {
        return $this->_children;
    }

    public function add(Collections_Tree_Nodeable $child) {
        $this->_children[$child->ident()] = $child;
    }

    public function remove($ident) {
        unset($this->_children[$ident]);
    }

    // Iterator functions
    protected $_visitable = true;

    public function setvisitable($visitable) {
        $this->_visitable = $visitable;
    }

    public function visitable() {
        return $this->_visitable;
    }

    protected $_visited = false;

    public function rewind() {
        $this->_visited = false;
        foreach ($this->_children as $child) {
            $child->rewind();
        }
    }

    public function key() {}

    public function current() {
        if (!$this->_visited && $this->_visitable) {
            $this->_visited = true;
            return $this;
        } else {
            foreach ($this->_children as $child) {
                if ($child->valid()) {
                    return $child->current();
                }
            }
        }
    }

    public function next() {}

    public function valid() {
        if (!$this->_visited && $this->_visitable) {
            return true;
        } else {
            $flag = false;
            foreach ($this->_children as $child) {
                $flag |= $child->valid();
            }
            return $flag;
        }
    }

    // Levels
    protected $_level = 0;

    public function setlevel($level) {
        $this->_level = $level;
    }

    public function level() {
        return $this->_level;
    }
}
