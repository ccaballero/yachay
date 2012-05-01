<?php

function breadcrumb($elements = array()) {
    global $BREADCRUMB;
    $config = Zend_Registry::get('config');

    $BREADCRUMB->items[] = array(
        'link'  => $config->resources->frontController->baseUrl,
        'label' => 'Inicio',
    );
    
    foreach ($elements as $element => $url) {
        $BREADCRUMB->items[] = array(
            'link' => $url,
            'label' => $element,
        );
    }
}

function normalize($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strtolower($string);
    return utf8_encode($string);
}

function convert($label) {
    $label = normalize($label);
    
    $translit = @iconv('UTF-8', 'ASCII//TRANSLIT', $label);
    $search = array('/[^a-z0-9]/', '/--+/', '/^-+/', '/-+$/');
    $replace = array('-', '-', '', '');
    return preg_replace($search, $replace, strtolower($translit));
}

function generatecode($type = 'alphanum', $code = NULL, $size = 16) {
    if ($type == 'alphanum') {
        $values = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
        $length = strlen($values);
        $code = '';
        for ($i = 0; $i < $size; $i++) {
            $code .= $values[rand(0, $length - 1)];
        }
        return $code;
    }
    if ($type == '.code.') {
        return ".$code.";
    }
    if ($type == '.edoc.') {
        $code = strrev($code);
        return ".$code.";
    }
}
