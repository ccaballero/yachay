<?php

class Yeah_Regions_Message
{
    private $_items = array();

    public function addMessage($message) {
        if (empty($message)) {
            return;
        }
        $this->_items[] = $message;
    }

    public function clean() {
        $this->_items = array();
    }

    public function getMessages() {
        return $this->_items;
    }
}
