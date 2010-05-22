<?php

class Yeah_Regions_Message
{
    private $_items = array();

    public function addMessage($message) {
        if (empty($message)) {
            return;
        }
        $conversor = new Yeah_Helpers_Utf2html;
        $this->_items[] = $conversor->utf2html($message);
    }

    public function clean() {
        $this->_items = array();
    }

    public function getMessages() {
        return $this->_items;
    }
}
