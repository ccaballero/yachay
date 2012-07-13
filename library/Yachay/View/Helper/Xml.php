<?php

class Yachay_View_Helper_Xml
{
    public function xml($object) {
        $dom_helper = new Yachay_View_Helper_Dom();
        $dom = $dom_helper->dom($object);
        return $dom->saveXML();
    }
}
