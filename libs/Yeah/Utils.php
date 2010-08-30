<?php

function mysql_import($sql) {
    $DATABASE = new Yeah_Settings_Database;
    $conexion = mysql_connect($DATABASE->hostname, $DATABASE->username, $DATABASE->password);
    mysql_select_db($DATABASE->database, $conexion);

    $f = fopen($sql, "r");
    $sqlFile = fread($f, filesize($sql));
    $sqlArray = explode(';', $sqlFile);

    foreach ($sqlArray as $stmt) {
        if (strlen($stmt) > 3) {
            $result = mysql_query($stmt, $conexion);
        }
    }
}

function print_params($array = array()) {
    $ret = '';
    foreach ($array as $key => $value) {
        $ret .= "[$key => $value] ";
    }
    return $ret;
}

function history($url_page = '') {
    global $CONFIG;

    $session = new Zend_Session_Namespace();
    $history = $session->history;
    $history->addUrl($CONFIG->wwwroot . $url_page);
}

function breadcrumb($elements = array()) {
    global $BREADCRUMB;
    global $CONFIG;

    $utf = new Yeah_Helpers_Utf2html;
    
    $BREADCRUMB->items[] = array(
                               'link'  => $CONFIG->wwwroot,
                               'label' => 'Inicio',
                           );
    
    foreach ($elements as $element => $url) {
        $BREADCRUMB->items[] = array(
            'link' => $url,
            'label' => $utf->utf2html($element),
        );
    }
}

function convert($label) {
    $a = 'ÁÀÄÂáàäâÉÈËÊéèëêÍÌÏÎíìïîÓÒÖÔóòöôÚÙÜÛúùüûÑñ ';
    $b = 'aaaaaaaaeeeeeeeeiiiiiiiioooooooouuuuuuuunn_';
    $label = strtolower($label);
    $label = strtr($label, utf8_decode($a), $b);

    $translit = @iconv('UTF-8', 'ASCII//TRANSLIT', $label);
    $search = array('/[^a-z0-9]/', '/--+/', '/^-+/', '/-+$/');
    $replace = array('-', '-', '', '');
    return preg_replace($search, $replace, strtolower($translit));
}

function generatecode($size = 10) {
    $values = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
    $length = strlen($values);
    $code = '';
    for ($i = 0; $i < $size; $i++) {
        $code .= $values[rand(0, $length - 1)];
    }
    return $code;
}

function context ($type,  $value = null) {
    $session = new Zend_Session_Namespace();
    $context = $session->context;

    switch ($type) {
    case 'global':
        $context->global = 1;
        $context->area = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'area':
        $context->global = 0;
        $context->area = $value;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'subject':
        $context->global = 0;
        $context->area = 0;
        $context->subject = $value;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'group':
        $context->global = 0;
        $context->area = 0;
        $context->subject = 0;
        $context->group = $value;
        $context->team = 0;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'team':
        $context->global = 0;
        $context->area = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = $value;
        $context->user = 0;
        $context->community = 0;
        break;
    case 'user':
        $context->global = 0;
        $context->area = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = $value;
        $context->community = 0;
        break;
    case 'community':
        $context->global = 0;
        $context->area = 0;
        $context->subject = 0;
        $context->group = 0;
        $context->team = 0;
        $context->user = 0;
        $context->community = $value;
        break;
    }
}
