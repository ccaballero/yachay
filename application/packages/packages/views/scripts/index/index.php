<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<table>';
foreach ($this->tree as $node) {
    echo '<tr><td>';
    echo str_repeat('&nbsp;&nbsp;', $node['level']);
    echo $this->reference($node['node']->label, $this->url(array('package' => $node['node']->url), 'packages_package_view'), array(array('packages', 'view')));
    echo '</td><td><i>' . $node['node']->description . '</i></td>';
    echo '</tr>';
}
echo '</table>';
