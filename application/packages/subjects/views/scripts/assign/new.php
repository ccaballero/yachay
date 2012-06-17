<?php

echo '<h1>Añadir miembros: ' . $this->subject->label . '</h1>';
echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8"><input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><input type="submit" value="Agregar usuarios" /></td><td><a href="' . $this->lastPage() . '">Cancelar</a></td></tr></table>';
echo '<hr />';

if (count($this->users)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>' . $this->model_users->_mapping['code'] . '</th>';
    echo '<th>' . $this->model_users->_mapping['label'] . '</th>';
    echo '<th>Nombre Completo</th>';
    echo '<th>' . $this->model_users->_mapping['role'] . '</th>';
    echo '<th>Cargo</th></tr>';
    foreach ($this->users as $user) {
        echo '<tr><td>' . $user->code . '</td>';
        echo '<td>' . $user->label . '</td>';
        echo '<td>' . $user->getFullName() . '</td>';
        echo '<td>' . $user->getRole()->label . '</td>';
        echo '<td><center>' . $this->assignement($user, 'users') . '</center></td></tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen usuarios disponibles</p>';
}

echo '<hr />';
echo '<table><tr><td><input type="submit" value="Agregar usuarios" /></td><td><a href="' . $this->lastPage() . '">Cancelar</a></td></tr></table>';
echo '</form>';
