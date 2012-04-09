<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if (count($this->users)) {
    echo '<center>';
    echo $this->paginator($this->users, $this->route);
    echo '<table width="100%">';
    foreach ($this->users as $user) {
        echo '<tr><td valign="top">';

        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '"><b>' . $user->label . '</b></a>';
        } else {
            echo '<b>' . $user->label . '</b>';
        }
        echo '&nbsp;';

        if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($user)) {
            echo '<b>[<i><a href="' . $this->url(array('user' => $user->url), 'users_user_edit') . '">Editar</a></i>]</b>';
        }

        if ($this->acl('friends', 'contact')) {
            if ($this->USER->ident != $user->ident) {
                if ($this->model_friends->hasContact($this->USER->ident, $user->ident)) {
                    echo '<a href="' . $this->url(array('user' => $user->url), 'friends_delete') . '">';
                    echo '<b>[<i>Retirar contacto</i>]</b>';
                    echo '</a>';
                } else {
                    echo '<a href="' . $this->url(array('user' => $user->url), 'friends_add') . '">';
                    echo '<b>[<i>Agregar contacto</i>]</b>';
                    echo '</a>';
                }
            }
        }

        echo '</td>';
        echo '<td valign="top"><b>Nombre Completo: </b>' . $user->getFullName() . '</td>';
        echo '</tr><tr>';
        echo '<td><b>Cargo: </b>' . $user->getRole()->label . '</td>';
        echo '<td><b>Carrera: </b>' . $this->none($user->getCareer()->label) . '</td>';
        echo '</tr><tr><td colspan="2"><b>Etiquetas: </b>';

        foreach ($user->getTags() as $tag) {
            echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
        }

        echo '</td></tr><tr><td colspan="2" valign="top">';
        echo '<b>Actividad: </b>' . $user->activity . '&nbsp;';
        echo '<b>Participacion: </b>' . $user->participation . '&nbsp;';
        echo '<b>Sociabilidad: </b>' . $user->sociability . '&nbsp;';
        echo '<b>Popularidad: </b>' . $user->popularity;
        echo '</td></tr>';
    }

    echo '</table>';
    echo $this->paginator($this->users, $this->route);
    echo '</center>';
} else {
    echo '<p>No existen usuarios registrados</p>';
}
