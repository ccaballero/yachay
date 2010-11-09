<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('gestions', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'gestions_list') . '">Lista</a>]</td>';
}
if ($this->acl('gestions', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'gestions_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('gestions', 'active')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->gestions)) {
    echo '<center><table width="100%"><tr><th>&nbsp;</th>';
    echo '<th>' . $this->model_gestions->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_gestions->_mapping['status'] . '</th>';
    echo '<th>Opciones</th>';
    echo '<th>' . $this->model_gestions->_mapping['tsregister'] . '</th>';
    echo '</tr>';

    foreach ($this->gestions as $gestion) {
        echo '<tr><td>';
        if ($this->acl('gestions', 'active')) {
            if ($gestion->status == 'active') {
                echo '<input type="radio" checked="checked" name="radio" value="' . $gestion->ident . '" />';
            } else {
                echo '<input type="radio" name="radio" value="' . $gestion->ident . '" />';
            }
        }

        echo '</td><td>' . $gestion->label . '</td>';
        echo '<td>' . $this->status($gestion->status) . '</td><td>';

        echo '<center>';
        if ($this->acl('gestions', 'view')) {
            echo '<a href="' . $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') . '">Ver</a> ';
        }
        if ($this->acl('gestions', 'delete')) {
            if ($gestion->status == 'inactive') {
                if ($gestion->isEmpty()) {
                    echo '<a href="' . $this->url(array('gestion' => $gestion->url), 'gestions_gestion_delete') . '">Eliminar</a> ';
                }
            }
        }
        if ($this->acl('gestions', 'active')) {
            if ($gestion->status == 'inactive') {
                echo '<a href="' . $this->url(array('gestion' => $gestion->url), 'gestions_gestion_active') . '">Activar</a>';
            }
        }
        echo '</center>';

        echo '</td><td><center>' . $this->timestamp($gestion->tsregister) . '</center></td></tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No existen gestiones registradas</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('gestions', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'gestions_list') . '">Lista</a>]</td>';
}
if ($this->acl('gestions', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'gestions_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('gestions', 'active')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '</form>';
