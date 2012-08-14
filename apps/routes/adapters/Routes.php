<?php

class Db_Routes extends Yachay_Db_Table
{
    protected $_name = 'route';
    protected $_primary = 'ident';
    protected $_modelClass = 'Routes_Route';

    public function tree() {
        $tree = new Collections_Tree();
        $routes = $this->selectAll();

        foreach ($routes as $route) {
            $tree->addNode($route);
        }

        $tree->indexAll();

        return $tree;
    }

    public function selectByEnabledPackages() {
        $result = $this->fetchAll($this
                ->select()
                ->setIntegrityCheck(false)
                ->from($this, array('ident', 'label', 'type', 'route' , 'mapping', 'module', 'controller', 'action', 'parent'))
                ->joinLeft('package', 'package.url = route.module', array())
                ->where('package.status = ?', 'active')
                ->order('route.ident DESC'));
        return $this->_constructList($result);
    }

    public function findByRoute($route) {
        $row = $this->fetchRow(
        $this->getAdapter()
             ->quoteInto('route = ?', $route));

        return $this->_constructObject($row);
    }
}
