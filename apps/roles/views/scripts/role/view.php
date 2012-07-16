<?php

echo '<h1>Rol: ' . $this->role->label . ' ';
if ($this->acl('roles', 'edit')) {
    echo '[<i><a href="' . $this->url(array('role' => $this->role->url), 'roles_role_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<p>' . $this->role->description . '</p>';

echo '<h2>Usuarios asignados</h2>';
if (count($this->users)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>' . $this->model_users->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_users->_mapping['formalname'] . '</th>';
    echo '<th>' . $this->model_users->_mapping['email'] . '</th>';
    echo '</tr>';

    foreach ($this->users as $user) {
        echo '<tr>';
        echo '<td>' . $user->label . '</td>';
        echo '<td>' . $user->getFullName() . '</td>';
        echo '<td><center>' . $user->email . '</center></td>';
        echo '</tr>';
    }
    
    echo '</table></center>';

} else {
    echo '<p>No se registraron usuarios.</p>';
}

echo '<h2>Privilegios asignados</h2>';
if (count($this->privileges)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>' . $this->model_privileges->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_privileges->_mapping['package'] . '</th>';
    echo '<th>' . $this->model_privileges->_mapping['privilege'] . '</th>';
    echo '</tr>';

    foreach ($this->privileges as $privilege) {
        echo '<tr>';
        echo '<td>' . $privilege->description . '</td>';
        echo '<td>' . $privilege->package . '</td>';
        echo '<td>' . $privilege->label . '</td>';
        echo '</tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No se registraron privilegios.</p>';
}
