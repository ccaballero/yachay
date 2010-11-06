<?php 

echo '<h1>' . $this->PAGE->label . '</h1>';

echo '<table><tr>';
if ($this->acl('roles', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_list') . '">Lista</a>]</td>';
}
if ($this->acl('roles', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('roles', 'assign')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_assign') . '">Asignación</a>]</td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->roles)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>' . $this->model_roles->_mapping['label'] . '</th>';
    echo '<th>Opciones</th>';
    echo '<th>' . $this->model_roles->_mapping['tsregister'] . '</th>';
    echo '</tr>';

    foreach ($this->roles as $role) {
        echo '<tr>';
        echo '<td>' . $role->label . '</td>';
        echo '<td><center>';

        if ($this->acl('roles', 'view')) {
            echo '<a href="' . $this->url(array('role' => $role->url), 'roles_role_view') . '">Ver</a> ';
        }
        if ($this->acl('roles', 'edit')) {
            echo '<a href="' . $this->url(array('role' => $role->url), 'roles_role_edit') . '">Editar</a> ';
        }
        if ($this->acl('roles', 'delete')) {
            if ($role->isEmpty()) {
                echo '<a href="' . $this->url(array('role' => $role->url), 'roles_role_delete') . '">Eliminar</a>';
            }
        }
        echo '</center></td>';
        echo '<td><center>' . $this->timestamp($role->tsregister) . '</center></td>';
        echo '</tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen roles registrados</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('roles', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_list') . '">Lista</a>]</td>';
}
if ($this->acl('roles', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('roles', 'assign')) {
    echo '<td>[<a href="' . $this->url(array(), 'roles_assign') . '">Asignación</a>]</td>';
}
echo '</tr></table>';
