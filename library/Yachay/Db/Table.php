<?php

abstract class Yachay_Db_Table extends Zend_Db_Table_Abstract
{
    // General selections
    public function selectAll() {
        $list = array();

        foreach ($this->fetchAll() as $row) {
            $list[] = $this->_construcObject($row);
        }

        return $list;
    }

    // Find by unique indexes
    public function findByIdent($ident) {
        $row = $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('ident = ?', $ident));

        return $this->_construcObject($row);
    }

    public function findByLabel($label) {
        $row = $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('label = ?', $label));

        return $this->_construcObject($row);
    }

    public function findByUrl($url) {
        $row = $this->fetchRow(
               $this->getAdapter()
                    ->quoteInto('url = ?', $url));

        return $this->_construcObject($row);
    }

    private function _construcObject($row) {
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
