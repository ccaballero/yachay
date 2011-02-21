<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if ($this->acl('friends', 'contact')) {
    echo '<table><tr>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_friends') . '">Amigos</a>]</td>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_followings') . '">Solicitudes</a>]</td>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_followers') . '">Peticiones</a>]</td>';
    echo '</tr></table>';
}
echo '<hr/>';

if (count($this->followings)) {
    echo '<table width="100%">';

    foreach ($this->followings as $following) {
        $user = $this->model_users->findByIdent($following->friend);
        echo '<tr><td valign="top">';

        if ($this->acl('users', 'view')) {
            echo '<b><a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">' . $user->label . '</a></b>';
        } else {
            echo '<b>' . $user->label . '</b>';
        }
        echo '&nbsp;';

        if ($this->acl('friends', 'contact')) {
            echo '[<a href="' . $this->url(array('user' => $user->url), 'friends_delete') . '"><b><i>Retirar contacto</i></b></a>]';
        }

        echo '</td>';
        echo '<td valign="top"><b>Nombre Completo: </b>' . $user->getFullName() . '</td></tr>';
        echo '<tr><td><b>Cargo: </b>' . $user->getRole()->label . '</td>';
        echo '<td><b>Carrera: </b>' . $this->none($user->getCareer()->label) . '</td></tr>';
        echo '<tr><td colspan="2"><b>Etiquetas: </b>';

        $tags = $user->getTags();
        foreach ($tags as $tag) {
            echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
        }

        echo '</td></tr><tr><td colspan="2" valign="top">';
        echo '<b>Actividad: </b>' . $user->activity . '&nbsp;';
        echo '<b>Participacion: </b>' . $user->participation . '&nbsp;';
        echo '<b>Sociabilidad: </b>' . $user->sociability . '&nbsp;';
        echo '<b>Popularidad: </b>' . $user->popularity . '</td></tr><tr>';
        echo '<td colspan="2"><b>Fecha de contacto: </b>' . $this->timestamp($following->tsregister) . '</td></tr>';
    }

    echo '</table>';
} else {
    echo '<p>No existen solicitudes registradas</p>';
}

echo '<hr/>';
if ($this->acl('friends', 'contact')) {
    echo '<table><tr>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_friends') . '">Amigos</a>]</td>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_followings') . '">Solicitudes</a>]</td>';
    echo '<td>[<a href="' . $this->url(array(), 'friends_followers') . '">Peticiones</a>]</td>';
    echo '</tr></table>';
}
