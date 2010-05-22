<?php

class Yeah_Regions_Icon
{
    public $icon;
    
    public function getCode() {
       return '<link rel="shortcut icon" href="' . $this->icon . '" />';
    }
}
