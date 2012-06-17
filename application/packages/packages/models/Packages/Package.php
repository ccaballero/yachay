<?php

class Packages_Package extends Zend_Db_Table_Row_Abstract implements Structures_Tree_Structurable
{
    public function element() {
        return 'package';
    }

    public function url() {
        return $this->label;
    }

    public function getIdent() {
        return $this->label;
    }

    public function getParent() {
        return $this->dependency;
    }
}
