<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<ul>';
foreach ($this->packages as $package) {
    echo '<li>';
    if ($this->acl('packages', 'view')) {
        echo '<a href="' . $this->url(array('mod' => $package->url), 'packages_package_view') . '"><b>' . $package->label . '</b></a>';
    } else {
        echo '<b>' . $package->label . '</b>';
    }
    echo '<br /><i>' . $package->description . '</i>';
    echo '</li>';
}
echo '</ul>';
