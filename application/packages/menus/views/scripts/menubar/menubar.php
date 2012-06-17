<?php 

global $MENUBAR;

$model_pages = new Pages();
$items = $model_pages->selectByMenutype('menubar');

foreach ($items as $item) {
    $perms = explode('|', $item->privilege);
    
    $bool = false;
    foreach ($perms as $perm) {
        if ($perm == '') {
            $bool |= true;
        } else {
            $bool |= $this->user->hasPermission($item->package, $perm);
        }
    }

    if ($bool) {
        $MENUBAR->items[] = array (
            'link'  => $this->url(array(), $item->route),
            'label' => ucfirst($item->title),
        );
    }
}
