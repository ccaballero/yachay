<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('users', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_list') . '">Lista</a>]</td>';
}
if ($this->acl('users', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('users', 'lock')) {
    echo '<td><input type="submit" name="lock" value="Bloquear" /></td>';
    echo '<td><input type="submit" name="unlock" value="Desbloquear" /></td>';
}
if ($this->acl('users', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
if ($this->acl('users', 'import')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_import') . '">Importar</a>]</td>';
}
if ($this->acl('users', 'export')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_export') . '">Exportar</a>]</td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->users)) {
    echo '<center><table width="100%"><tr><th>&nbsp;</th>';
    echo '<th>' . $this->model->_mapping['label'] . '</th>';
    echo '<th>Nombre Completo</th><th>Opciones</th>';
    echo '<th>' . $this->model->_mapping['tsregister'] . '</th></tr>';

    foreach ($this->users as $user) {
        echo '<tr><td>';

        if ($this->acl('users', array('lock', 'delete'))) {
            echo '<input type="checkbox" name="check[]" value="' . $user->ident . '" />';
        }

        echo '</td>';
        echo '<td>' . $user->label . '</td>';
        echo '<td>' . $user->getFullName() . '</td>';
        echo '<td>';

        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">Ver</a>&nbsp;';
        }
        if ($this->user->hasFewerPrivileges($user)) {
            if ($this->acl('users', 'edit')) {
                echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_edit') . '">Editar</a>&nbsp;';
            }
            if ($this->acl('users', 'lock')) {
                if ($user->status == 'active') {
                    echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_lock') . '">Bloquear</a>&nbsp;';
                } else {
                    echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_unlock') . '">Desbloquear</a>&nbsp;';
                }
            }
            if ($this->acl('users', 'delete')) {
                echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_delete') . '">Eliminar</a>&nbsp;';
            }
        }

        echo '</td>';
        echo '<td><center>' . $this->timestamp($user->tsregister) . '</center></td></tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No existen usuarios registrados</p>';
}
echo '<hr />';

echo '<table><tr>';
if ($this->acl('users', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_list') . '">Lista</a>]</td>';
}
if ($this->acl('users', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('users', 'lock')) {
    echo '<td><input type="submit" name="lock" value="Bloquear" /></td>';
    echo '<td><input type="submit" name="unlock" value="Desbloquear" /></td>';
}
if ($this->acl('users', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
if ($this->acl('users', 'import')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_import') . '">Importar</a>]</td>';
}
if ($this->acl('users', 'export')) {
    echo '<td>[<a href="' . $this->url(array(), 'users_export') . '">Exportar</a>]</td>';
}
echo '</tr></table>';
echo '</form>';
