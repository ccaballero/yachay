<?php

$menubar = array();

foreach($this->menubar->items as $item) {
    $menubar[] = "<a href=\"{$item['link']}\">{$item['label']}</a>";
}

echo '| ' . implode(' | ', $menubar) . ' |';
