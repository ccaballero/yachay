<?php

echo '<h1>' . $this->route->label . '</h1>';
if (count($this->areas)) {
    echo '<ul>';
    foreach ($this->areas as $area) {
        echo '<li>';
        if ($this->acl('areas', 'view')) {
            echo '<a href="' . $this->url(array('area' => $area->url), 'areas_area_view') . '"><b>' . $area->label . '</b></a>';
        } else {
            echo '<b>' . $area->label . '</b>';
        }
        echo '&nbsp;';
        if ($this->acl('areas', 'edit')) {
            echo '<b><i>[<a href="' . $this->url(array('area' => $area->url), 'areas_area_edit') . '">Editar</a>]</i></b>';
        }
        echo '<br /><i>' . $area->description . '</i>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen areas registradas</p>';
}
