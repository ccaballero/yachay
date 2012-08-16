<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<table>';
foreach ($this->list as $node) {
    echo '<tr><td>';
    echo str_repeat('&nbsp;&nbsp;', $node->level());
    echo $this->reference($node->label, $this->url(array('package' => $node->url), 'packages_package_view'), array(array('packages', 'view')));
    echo '</td><td><i>' . $node->description . '</i></td>';
    echo '</tr>';
}
echo '</table>';
