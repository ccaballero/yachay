<?php

echo '<h1>Etiqueta: ' . $this->tag->label . '</h1>';
echo '<table width="100%"><tr>';
if (count($this->communities) <> 0) {
    echo '<td valign="top">';
    echo '<h2>Comunidades</h2>';
    echo '<ul>';
    foreach ($this->communities as $community) {
        echo '<li>';
        if ($this->acl('communities', 'view')) {
            echo '<a href="' . $this->url(array('community' => $community->url), 'communities_community_view') . '">';
        }
        echo $community->label;
        if ($this->acl('communities', 'view')) {
            echo '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
    echo '</td>';
}
if (count($this->users) <> 0) {
    echo '<td valign="top">';
    echo '<h2>Usuarios</h2>';
    echo '<ul>';
    foreach ($this->users as $user) {
        echo '<li>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $user->url), 'users_user_view') . '">';
        }
        echo $user->getFullName();
        if ($this->acl('users', 'view')) {
            echo '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
    echo '</td>';
}
echo '</tr>';
echo '</table>';
echo $this->partial('resource.php', array('resources' => $this->resources, 'pager' => $this->pager));
