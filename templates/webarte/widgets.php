<?php

$widgets = $this->WIDGETS;
$count = count($widgets);
$order = array(1, 3, 2, 4);

foreach ($order as $i) {
    if (!empty($widgets[$i])) {
        $title = '';
        if (!empty($widgets[$i]['title'])) {
            $title = "<h2>{$widgets[$i]['title']}</h2>";
        }
        echo "<div class=\"widget\">$title {$widgets[$i]['content']}</div>";
    } else {
        echo '';
    }
}
