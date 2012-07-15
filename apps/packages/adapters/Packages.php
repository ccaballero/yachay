<?php

class Db_Packages extends Yachay_Db_Table
{
    protected $_name = 'package';
    protected $_primary = 'ident';
    protected $_modelClass = 'Packages_Package';

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status));
    }

    public function selectByType($type) {
        return $this->fetchAll($this->select()->where('type = ?', $type));
    }

    public function tree() {
        $tree = new Collections_Tree();
        $packages = $this->selectAll();

        foreach ($packages as $package) {
            $tree->addNode($package);
        }

        $tree->indexAll();

        return $tree;
    }

    public function lock($elements) {
        if (count($elements) > 0) {
            return $this->update(array('status' => 'inactive'), array('ident IN (?)' => $elements));
        } else {
            return 0;
        }
    }

    public function unlock($elements) {
        if (count($elements) > 0) {
            return $this->update(array('status' => 'active'), array('ident IN (?)' => $elements));
        } else {
            return 0;
        }
    }
}
