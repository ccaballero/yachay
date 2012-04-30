<?php

global $FOOTER;
global $USER;

$config = Zend_Registry::get('config');
$model_pages = new Pages();
$items = $model_pages->selectByMenutype('footer');

foreach ($items as $item) {
    $perms = explode('|', $item->privilege);
    $bool = false;
    foreach ($perms as $perm) {
        $bool |= $USER->hasPermission($item->module, $perm);
    }

    if ($bool) {
        $FOOTER->items[] = array (
            'link'  => $this->moduleToUrl($item->module, $item->controller, $item->action),
            'label' => ucfirst($item->title),
        );
    }
}

$FOOTER->copyright = date("Y") . ' yachay ' . $config->yachay->properties->version;
