<?php

class Yachay_Settings_History
{
    private $_items;
    private $_count;
    private $_limit;

    public function __construct() {
        $this->_items = array();
        $this->_count = 0;
        $this->_limit = 5;
    }

    public function addUrl($url) {
        if ($this->_count > 0) {
            $lasturl = $this->_items[($this->_count - 1) % $this->_limit];
            if ($lasturl == $url) {
                return;
            }
        }
        $this->_items[$this->_count % $this->_limit] = $url;
        $this->_count++;
    }

    public function lastUrl() {
        if ($this->_count > 1) {
            return $this->_items[($this->_count - 2) % $this->_limit];
        }
        global $CONFIG;
        return $CONFIG->wwwroot;
    }

    public function currentUrl() {
        if ($this->_count > 0) {
            return $this->_items[($this->_count - 1) % $this->_limit];
        }
        global $CONFIG;
        return $CONFIG->wwwroot;
    }

    public function toString() {
        $ret = ' *********************************************** ' . $this->_count . '
';
        for ($i = 0; $i < count($this->_items); $i++) {
            $arrow = '  ';
            if (($this->_count - 1) % $this->_limit == $i) {
                $arrow = '->';
            }
            $ret .= '                                 '
                 . $arrow . '  ' . $this->_items[$i] . '
';
        }
        return $ret;
    }
}
