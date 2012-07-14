<?php

class Collections_Tree implements Iterator
{
    const IDROOT = 65535;

    protected $_root;
    protected $_nodes;
    protected $_orphans;

    public function __construct() {
        $this->_root = new Collections_Tree_Node_Default(self::IDROOT);
        $this->_root->setvisitable(false);
        $this->_nodes = array();
        $this->_orphans = array();
    }

    public function getRoot() {
        return $this->_root;
    }

    public function getNodes() {
        return $this->_nodes;
    }

    public function getNode($ident) {
        return $this->_nodes[$ident];
    }

    public function getOrphans() {
        return $this->_orphans;
    }

    public function addNode(Collections_Tree_Nodeable $node) {
        // Add the node in the list of nodes
        $this->_nodes[$node->ident()] = $node;

        if ($node->parent() == null) { // Node has no parent
            $this->_root->add($node);
        } else if (isset($this->_nodes[$node->parent()])) { // Node has parent registered
            $this->_nodes[$node->parent()]->add($node);
        } else { // Node has parent but is not registered
            $this->_orphans[$node->parent()][] = $node;
        }

        if (array_key_exists ($node->ident(), $this->_orphans)) { // 
            foreach ($this->_orphans[$node->ident()] as $orphan) {
                $node->add($orphan);
            }
            unset($this->_orphans[$node->ident()]);
        }
    }

    // Level functions
    public function indexAll() {
        $this->index($this->_root, 0);
    }

    private function index($node, $level) {
        foreach ($node->children() as $child) {
            $child->setlevel($level);
            $this->index($child, $level + 1);
        }
    }

    // Iterator functions
    public function rewind() {
        $this->_root->rewind();
    }

    public function key() {
        return $this->_root->key();
    }

    public function current() {
        return $this->_root->current();
    }

    public function next() {
        $this->_root->key();
    }

    public function valid() {
        return $this->_root->valid();
    }

    // Utilities
    public function path($ident) {
        if (!isset($this->_nodes[$ident])) {
            return null;
        }

        $ident = $this->_nodes[$ident]->ident();
        $parent = $this->_nodes[$ident]->parent();
        
        $array = array($this->_nodes[$ident]);

        if (!empty($parent)) {
            $array = array_merge($array, $this->path($parent));
        }

        return $array;
    }
}
