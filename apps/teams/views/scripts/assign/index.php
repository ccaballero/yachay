<?php

echo '<h1>' . $this->route->label . '</h1>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') . '">Administrador</a>]</td>';
echo '<td><input type="submit" value="Actualizar" /></td>';
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->members)) {
    echo '<center>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th>Usuario</th>';
    echo '<th>Nombre Completo</th>';
    echo '<th>Equipo</th>';
    echo '</tr>';
    foreach ($this->members as $member) {
        echo '<tr>';
        echo '<td>' . $member->label . '</td>';
        echo '<td>' . $member->getFullName() . '</td>';
        echo '<td><center>' . $this->teams('team', 0, $this->group, $member->ident) . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</center>';
} else {
    echo '<p>No existen usuarios sin asignación de equipo.</p>';
}
echo '<hr />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') . '">Administrador</a>]</td>';
echo '<td><input type="submit" value="Actualizar" /></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
