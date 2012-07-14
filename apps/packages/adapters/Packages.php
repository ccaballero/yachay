<?php

class Db_Packages extends Yachay_Model_Table
{
    protected $_name = 'package';
    protected $_primary = 'ident';
    protected $_rowClass = 'Db_Packages_Package';
    protected $_modelClass = 'Packages_Package';

    protected $_dependentTables = array('Packages');
    protected $_referenceMap    = array(
        'Dependency'            => array(
            'columns'           => 'dependency',
            'refTableClass'     => 'Packages',
            'refColumns'        => 'url',
            'onDelete'          => self::RESTRICT,
            'onUpdate'          => self::CASCADE,
        ),
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    // Selects in table
    public function selectAll() {
        $list = array();

        foreach ($this->fetchAll() as $row) {
            $bean = new $this->_modelClass($row->url, $row->parent);
            $reflect = new ReflectionObject($bean);
            $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

            foreach ($properties as $property) {
                $key = $property->getName();
                $bean->$key = $row->$key;
            }

            $list[] = $bean;
        }

        return $list;
    }

    public function selectByStatus($status) {
        return $this->fetchAll($this->select()->where('status = ?', $status));
    }

    public function selectByType($type) {
        return $this->fetchAll($this->select()->where('type = ?', $type));
    }

    public function getTree() {
        $tree = new Collections_Tree();

        foreach ($this->selectAll() as $package) {
            $tree->addNode($package);
        }
        $tree->indexAll();

        return $tree;
    }

    public function locks($packages) {
        $this->update(array('status' => 'inactive'), array('url IN (?)' => $packages));
    }
    
    public function unlocks($packages) {
        $this->update(array('status' => 'active'), array('url IN (?)' => $packages));
    }
}
