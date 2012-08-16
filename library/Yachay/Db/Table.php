<?php

abstract class Yachay_Db_Table extends Zend_Db_Table_Abstract
{
    // Find by unique indexes
    public function findAdapterByIdent($ident) {
        return $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('ident = ?', $ident));
    }

    public function findByIdent($ident) {
        return $this->_constructObject($this->findAdapterByIdent($ident));
    }

    public function findByLabel($label) {
        $row = $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('label = ?', $label));

        return $this->_constructObject($row);
    }

    public function findByUrl($url) {
        $row = $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('url = ?', $url));

        return $this->_constructObject($row);
    }

    // General selections
    public function selectAllAdapters() {
        return $this->fetchAll();
    }

    public function selectAll() {
        return $this->_constructList($this->selectAllAdapters());
    }

    // Generic constructors of bean objects
    protected function _constructList(Iterator $resultset) {
        $list = array();
        foreach ($resultset as $row) {
            $list[] = $this->_constructObject($row);
        }
        return $list;
    }

    protected function _constructObject($row) {
        $object = new $this->_modelClass();
        $reflect = new ReflectionObject($object);

        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $key = $property->getName();
            $object->$key = $row->$key;
        }

        return $object;
    }
}
