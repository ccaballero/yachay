<?php

echo '<h1>Comunidad: ' . $this->community->label;
if ($this->community->amAuthor()) {
    echo ' <b><i>[<a href="' . $this->url(array('community' => $this->community->url), 'communities_community_edit') . '">Editar</a>]</i></b>';
}
if ($this->acl('communities', 'enter')) {
    if (!$this->community->amModerator() && !$this->community->amMember()) {
        echo '[<a href="' . $this->url(array('community' => $this->community->url), 'communities_community_join') . '">Unirse</a>]';
    } else if (!$this->community->amAuthor()) {
        echo '[<a href="' . $this->url(array('community' => $this->community->url), 'communities_community_leave') . '">Retirarse</a>]';
    }
}
echo '</h1>';

echo '<table width="100%">';
echo '<tr valign="top">';
echo '<td><b>Descripción: </b></td>';
echo '</tr>';
echo '<tr><td>' . $this->community->description . '</td></tr>';
echo '<tr valign="top"><td><b>Modalidad: </b>' . $this->mode(NULL, $this->community->mode) . '</td></tr>';
echo '<tr valign="top">';
echo '<td colspan="2">';
echo '<b>Etiquetas: </b>';

$tags = $this->community->getTags();
foreach ($tags as $tag) {
    echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
}
echo '</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td>';
echo '<b>Autor: </b>';

if ($this->acl('users', 'view')) {
    echo '<a href="' . $this->url(array('user' => $this->community->getAuthor()->url), 'users_user_view') . '">' . $this->community->getAuthor()->getFullName() . '</a>';
} else {
    echo $this->community->getAuthor()->getFullName();
}
echo '</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td>';
echo '<b>Miembros: </b>' . $this->community->members;
if ($this->acl('communities', 'enter')) {
    echo ' <i><a href="' . $this->url(array('community' => $this->community->url), 'communities_community_assign') . '">[Ver miembros]</a></i>';
}
echo '</td>';
echo '</tr>';
if ($this->community->mode == 'close') {
    echo '<tr valign="top">';
    echo '<td>';
    echo '<b>Peticiones: </b>' . $this->community->petitions;
    if ($this->community->amModerator()) {
        echo ' <i><a href="' . $this->url(array('community' => $this->community->url), 'communities_community_petition') . '">[Ver peticiones]</a></i>';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</table>';

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'template' => $this->template));
