<?php

class Packages_Package extends Zend_Db_Table_Row_Abstract implements Collections_Tree_Structurable
{
    private $tree = null;

    public function getIdent() {
        return $this->label;
    }

    public function getParent() {
        return $this->dependency;
    }

    public function setTree(Collections_Tree $tree) {
        $this->tree = $tree;
    }

    public function getTree() {
        if (empty($this->tree)) {
            $model_packages = new Packages();
            $this->tree = $model_packages->getTree();
        }
        return $this->tree;
    }

    public function arrayDown() {
        $tree = $this->getTree();
        $node = $tree->getNode($this->getIdent());
        return $node->arrayDown();
    }

    public function arrayUp() {
        $tree = $this->getTree();
        return $tree->arrayUp($this->getIdent());
    }
}
