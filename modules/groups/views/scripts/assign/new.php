<?php

echo '<h1>Añadir miembros: Grupo ' . $this->group->label . '</h1>';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td><input type="submit" value="Agregar usuarios" /></td>';
echo '<td><a href="' . $this->lastPage() . '">Cancelar</a></td>';
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->users)) {
    echo '<center>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th>' . $this->model_users->_mapping['code'] . '</th>';
    echo '<th>' . $this->model_users->_mapping['label'] . '</th>';
    echo '<th>Nombre Completo</th>';
    echo '<th>' . $this->model_users->_mapping['role'] . '</th>';
    echo '<th>Cargo</th>';
    echo '</tr>';
    foreach ($this->users as $user) {
        echo '<tr>';
        echo '<td>' . $user->code . '</td>';
        echo '<td>' . $user->label . '</td>';
        echo '<td>' . $user->getFullName() . '</td>';
        echo '<td>' . $user->getRole()->label . '</td>';
        echo '<td><center>' . $this->assignement($user, $this->subject, $this->group, 'users') . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</center>';
} else {
    echo '<p>No existen usuarios disponibles</p>';
}
echo '<hr />';

echo '<table';
echo '<tr>';
echo '<td><input type="submit" value="Agregar usuarios" /></td>';
echo '<td><a href="' . $this->lastPage() . '">Cancelar</a></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
