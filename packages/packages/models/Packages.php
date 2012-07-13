<?php

class Packages extends Yachay_Models_Table
{
    protected $_name = 'package';
    protected $_primary = 'ident';
    protected $_rowClass = 'Packages_Package';

    protected $_dependentTables = array('Packages');
    protected $_referenceMap    = array(
        'Dependency'            => array(
            'columns'           => 'dependency',
            'refTableClass'     => 'Packages',
            'refColumns'        => 'label',
            'onDelete'          => self::RESTRICT,
            'onUpdate'          => self::CASCADE,
        ),
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByUrl($url) {
        return $this->fetchRow($this->getAdapter()->quoteInto('url = ?', $url));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('type ASC')->order('label ASC'));
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
        $this->update(array('status' => 'inactive'), array('label IN (?)' => $packages));
    }
    
    public function unlocks($packages) {
        $this->update(array('status' => 'active'), array('label IN (?)' => $packages));
    }
}
