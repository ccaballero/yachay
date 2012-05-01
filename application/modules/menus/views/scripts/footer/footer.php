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
        if ($perm == '') {
            $bool |= true;
        } else {
            $bool |= $USER->hasPermission($item->module, $perm);
        }
    }

    if ($bool) {
    var_dump($item->label);
        $FOOTER->items[] = array (
            'link'  => $this->url(array(), $item->route),
            'label' => ucfirst($item->title),
        );
    }
}

$FOOTER->copyright = 'yachay ' . $config->yachay->properties->version;
