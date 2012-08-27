<?php

class Yachay_View_Helper_Dom
{
    private $_dom = null;

    public function  __construct() {
        $config = Zend_Registry::get('config');
        
        $implementation = new DOMImplementation();
        $dtd = $implementation->createDocumentType('yachay', '', $config->system->url . '/yachay.dtd');

        $this->_dom = $implementation->createDocument('', '', $dtd);
        $this->_dom->encoding = 'utf-8';        
    }

    public function dom($object) {
        $this->_dom->appendChild($this->_parse($object));
        return $this->_dom;
    }

    private function _parse($content, $parent = 'yachay') {
        if ($content instanceof Yachay_Db_Table_Row) {
            $element = $this->_dom->createElement($parent);

            foreach (array_diff(get_class_methods($content), get_class_methods(get_parent_class($content))) as $method) {
                if (substr($method, 0, 3) === 'get') {
                    $element->appendChild($this->_parse($content->{$method}(), strtolower(substr($method, 3))));
                }
            }
        } else if ($content instanceof Zend_Db_Table_Rowset) {
            $element = $this->_dom->createElement($parent);

            $url = new Zend_View_Helper_Url();

            $table = strtolower($content->getTableClass());
            foreach ($content as $row) {
                $item = $this->_dom->createElement('item');

                $item->appendChild($this->_dom->createElement('class', $table));
                $item->appendChild($this->_parse($row, 'data'));

                $actions = $this->_dom->createElement('actions');
                $model_routes = new Routes();
                $tasks = $model_routes->selectByModuleAndController($table, 'element');
                foreach ($tasks as $task) {
                    $actions->appendChild($this->_dom->createElement(
                        $task->action, $url->url(array($row->element() => $row->url()), '1_' . $task->label)
                    ));
                }
                $item->appendChild($actions);

                $element->appendChild($item);
            }
        } else if (is_array($content)) {
            $element = $this->_dom->createElement($parent);
            foreach ($content as $key => $value) {
                if (is_numeric($key)) {
                    $key = 'item';
                }

                $element->appendChild($this->_parse($value, $key));
            }
        } else if (is_object($content)) {
            $element = $this->_dom->createElement($parent);
            $reflect = new ReflectionObject($content);

            $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
            foreach ($properties as $property) {
                $element->appendChild($this->_parse($property->getValue($content), $property->getName()));
            }
        } else {
            $element = $this->_dom->createElement($parent, $content);
        }

        return $element;
    }
}
