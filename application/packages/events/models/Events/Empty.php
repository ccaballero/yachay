<?php

class Events_Empty
{
    public $label = '';
    public $place = '';
    public $message = '';
    public $event = '';
    public $duration = '';

    public function Events_Empty() {
        $this->event = date('Y-n-j-H-i', time());
    }
}
