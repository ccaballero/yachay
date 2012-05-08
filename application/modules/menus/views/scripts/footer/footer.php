<?php

global $FOOTER;

$model_pages = new Pages();
$items = $model_pages->selectByMenutype('footer');

foreach ($items as $item) {
    $perms = explode('|', $item->privilege);

    $bool = false;
    foreach ($perms as $perm) {
        if ($perm == '') {
            $bool |= true;
        } else {
            $bool |= $this->user->hasPermission($item->module, $perm);
        }
    }

    if ($bool) {
        $FOOTER->items[] = array (
            'link'  => $this->url(array(), $item->route),
            'label' => ucfirst($item->title),
        );
    }
}

$FOOTER->copyright = 'yachay ' . $this->config->yachay->properties->version;
