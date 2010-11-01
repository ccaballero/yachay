<?php

$footer = array();
foreach($this->footer->items as $item) {
    $footer[] = "<a href=\"{$item['link']}\">{$item['label']}</a>";
}

echo '| ' . implode(' | ', $footer) . ' |' . (count($footer) == 0 ? '' : '<br />') . $this->footer->copyright;
