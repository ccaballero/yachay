<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';
echo '<br />';
echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'groups_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" value="Activar" name="unlock" /></td>';
echo '<td><input type="submit" value="Desactivar" name="lock" /></td>';
echo '<td><input type="submit" value="Eliminar" name="delete" /></td>';
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->groups)) {
    echo '<center>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th>&nbsp;</th>';
    echo '<th>' . $this->model_groups->_mapping['label'] . '</th>';
    echo '<th>Opciones</th>';
    echo '<th>' . $this->model_groups->_mapping['tsregister'] . '</th>';
    echo '</tr>';
        foreach ($this->groups as $group) {
        echo '<tr>';
        echo '<td>';
        echo '<input type="checkbox" name="check[]" value="' . $group->ident . '" />';
        echo '</td>';
        echo '<td>' . $group->label . '</td>';
        echo '<td>';
        echo '<center>';
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_view') . '">Ver</a> ';
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_edit') . '">Editar</a> ';
            if ($group->status == 'inactive') {
                echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_unlock') . '">Activar</a> ';
            } else {
                echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_lock') . '">Desactivar</a> ';
            }
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_delete') . '">Eliminar</a>';
        echo '</center>';
        echo '</td>';
        echo '<td><center>' . $this->timestamp($group->tsregister) . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</center>';
} else {
    echo '<p>No existen grupos registrados en la materia</p>';
}
echo '<hr />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'groups_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" value="Activar" name="unlock" /></td>';
echo '<td><input type="submit" value="Desactivar" name="lock" /></td>';
echo '<td><input type="submit" value="Eliminar" name="delete" /></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
