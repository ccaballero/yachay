<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<ul>';
foreach ($this->modules as $module) {
    echo '<li>';
    if ($this->acl('modules', 'view')) {
        echo '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_view') . '"><b>' . $module->label . '</b></a>';
    } else {
        echo '<b>' . $module->label . '</b>';
    }
    echo '<br /><i>' . $module->description . '</i>';
    echo '</li>';
}
echo '</ul>';
