<?php

echo '<h1>Usuario: ' . $this->user->label;
if ($this->acl('users', 'edit') && $this->me->hasFewerPrivileges($this->user)) {
    echo '[<i><a href="' . $this->url(array('user' => $this->user->url), 'users_user_edit') . '">Editar</a></i>]';
}
if ($this->acl('friends', 'contact')) {
    if ($this->me->ident != $this->user->ident) {
        if ($this->model_friends->hasContact($this->me->ident, $this->user->ident)) {
            echo '[<a href="' . $this->url(array('user' => $this->user->url), 'friends_delete') . '"><b><i>Retirar contacto</i></b></a>]';
        } else {
            echo '[<a href="' . $this->url(array('user' => $this->user->url), 'friends_add') . '"><b><i>Agregar contacto</i></b></a>]';
        }
    }
}
echo '</h1>';

echo '<table width="100%"><tr valign="top">';
echo '<td colspan="4"><b>Nombre Completo: </b>' . $this->user->getFullName() . '</td></tr><tr valign="top">';
echo '<td colspan="2"><b>Cargo: </b>' . $this->user->getRole()->label . '</td>';
echo '<td colspan="2"><b>Carrera: </b>' . $this->none($this->user->getCareer()->label) . '</td></tr>';
echo '<tr valign="top"><td colspan="4"><b>Etiquetas: </b>';

foreach ($this->user->getTags() as $tag) {
    echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
}

echo '</td></tr><tr><td colspan="4">';
echo '<b>Actividad: </b>' . $this->user->activity . '&nbsp;';
echo '<b>Participacion: </b>' . $this->user->participation . '&nbsp;';
echo '<b>Sociabilidad: </b>' . $this->user->sociability . '&nbsp;';
echo '<b>Popularidad: </b>' . $this->user->popularity;
echo '</td></tr>';

echo '<tr valign="top"><td colspan="4"><b>Descripcion Personal:</b></td></tr>';
echo '<tr valign="top"><td colspan="4">' . $this->none($this->user->description) . '</td></tr>';
echo '<tr valign="top"><td colspan="4"><b>Pasatiempos:</b></td></tr>';
echo '<tr valign="top"><td colspan="4">' . $this->none($this->user->hobbies) . '</td></tr>';
echo '</table><hr />';

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'template' => $this->template));
