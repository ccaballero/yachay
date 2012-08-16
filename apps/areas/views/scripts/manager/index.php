<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8"><input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('areas', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'areas_list') . '">Lista</a>]</td>';
}
if ($this->acl('areas', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'areas_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';

echo '<hr />';
if (count($this->areas)) {
    echo '<center><table width="100%">';
    echo '<tr><th>' . $this->model_areas->_mapping['label'] . '</th><th>Opciones</th><th>' . $this->model_areas->_mapping['tsregister'] . '</th></tr>';
    foreach ($this->areas as $area) {
        echo '<tr><td>' . $area->label . '</td><td><center>';
        if ($this->acl('areas', 'view')) {
            echo '<a href="' . $this->url(array('area' => $area->url), 'areas_area_view') . '">Ver</a> ';
        }
        if ($this->acl('areas', 'edit')) {
            echo '<a href="' . $this->url(array('area' => $area->url), 'areas_area_edit') . '">Editar</a> ';
        }
        if ($this->acl('areas', 'delete')) {
            if ($area->isEmpty()) {
                echo '<a href="' . $this->url(array('area' => $area->url), 'areas_area_delete') . '">Eliminar</a>';
            }
        }
        echo '</center></td><td><center>' . $this->timestamp($area->tsregister) . '</center></td></tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen areas registradas</p>';
}
echo '<hr />';

echo '<table><tr>';
if ($this->acl('areas', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'areas_list') . '">Lista</a>]</td>';
}
if ($this->acl('areas', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'areas_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';

echo '</form>';
