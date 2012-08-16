<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<b>Grupo: </b><i>' . $this->group->label . '</i>';
echo '<br />';
echo '<b>Materia: </b><i>' . $this->subject->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" value="Activar" name="unlock" /></td>';
echo '<td><input type="submit" value="Desactivar" name="lock" /></td>';
echo '<td><input type="submit" value="Eliminar" name="delete" /></td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') . '">Asignación</a>]</td>';
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->teams)) {
    echo '<center>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th>&nbsp;</th>';
    echo '<th>' . $this->model_teams->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_teams->_mapping['status'] . '</th>';
    echo '<th>Opciones</th>';
    echo '<th>' . $this->model_teams->_mapping['tsregister'] . '</th>';
    echo '</tr>';

    foreach ($this->teams as $team) {
        echo '<tr>';
        echo '<td>';
        echo '<input type="checkbox" name="check[]" value="' . $team->ident . '" />';
        echo '</td>';
        echo '<td>' . $team->label . '</td>';
        echo '<td>' . $this->status($team->status) . '</td>';
        echo '<td>';
        echo '<center>';
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') . '">Ver</a> ';
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_edit') . '">Editar</a> ';
        if ($team->status == 'inactive') {
            echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_unlock') . '">Activar</a> ';
        } else {
            echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_lock') . '">Desactivar</a> ';
        }
        echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_delete') . '">Eliminar</a>';
        echo '</center>';
        echo '</td>';
        echo '<td><center>' . $this->timestamp($team->tsregister) . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</center>';
} else {
    echo '<p>No existen equipos registrados en el grupo</p>';
}
echo '<hr />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" value="Activar" name="unlock" /></td>';
echo '<td><input type="submit" value="Desactivar" name="lock" /></td>';
echo '<td><input type="submit" value="Eliminar" name="delete" /></td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') . '">Asignación</a>]</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
