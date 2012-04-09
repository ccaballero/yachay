<?php

class Yachay_Regions_Breadcrumb
{
    public $items = array();

    public function toString() {
        $ret = ' **************************************************
';
        foreach ($this->items as $item) {
            $ret .= "                                     {$item['label']} -> {$item['link']}
";
        }
        return $ret;
    }
}
