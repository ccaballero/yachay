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

function context ($type,  $value = null) {
    $session = new Zend_Session_Namespace('yachay');
    $context = $session->context;

    switch ($type) {
    case 'global':
        $context->global = 1;
        $context->area = 0;
        $context->career = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'area':
        $context->global = 0;
        $context->area = $value;
        $context->career = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'career':
        $context->global = 0;
        $context->area = 0;
        $context->career = $value;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'subject':
        $context->global = 0;
        $context->area = 0;
        $context->career = 0;
        $context->subject = $value;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'group':
        $context->global = 0;
        $context->area = 0;
        $context->career = 0;
        $context->subject = 0;
        $context->group = $value;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'team':
        $context->global = 0;
        $context->area = 0;
        $context->career = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = $value;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'user':
        $context->global = 0;
        $context->area = 0;
        $context->career = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = $value;
        $context->community = 0;
        break;
    case 'community':
        $context->global = 0;
        $context->area = 0;
        $context->career = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = $value;
        break;
    }
}
