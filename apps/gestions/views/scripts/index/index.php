<?php

echo '<h1>' . $this->route->label . '</h1>';
if (count($this->gestions)) {
    echo '<ul>';
    foreach ($this->gestions as $gestion) {
        echo '<li>';
        if ($this->acl('gestions', 'view')) {
            echo '<a href="' . $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') . '">';
            echo '<b>' . $gestion->label . '</b>';
            echo '</a>';
        } else {
            echo '<b>' . $gestion->label . '</b>';
        }
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen gestiones registradas</p>';
}
