<?php

class modules_events_models_Events_Empty
{
    public $label = '';
    public $place = '';
    public $message = '';
    public $event = '';
    public $duration = '';

    public function modules_events_models_Events_Empty() {
        $this->event = date('Y-n-j-H-i', time());
    }
}
