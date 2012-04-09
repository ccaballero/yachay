<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if (count($this->roles)) {
    echo '<dl>';
    foreach ($this->roles as $role) {
        echo '<dt>';
        if ($this->acl('roles', 'view')) {
            echo '<a href="' . $this->url(array('role' => $role->url), 'roles_role_view') . '"><b>' . $role->label . '</b></a>';
        } else {
            echo '<b>' . $role->label . '</b>';
        }
        if ($this->acl('roles', 'edit')) {
            echo '&nbsp;<b><i>[<a href="' . $this->url(array('role' => $role->url), 'roles_role_edit') . '">Editar</a>]</i></b>';
        }
        echo '</dt><dd><i>' . $role->description . '</i></dd>';
    }
    echo '</dl>';
} else {
    echo '<p>No existen roles registrados</p>';
}
