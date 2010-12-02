<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
if (count($this->communities)) {
    echo '<center>' . $this->paginator($this->communities, $this->route) . '</center>';
    foreach ($this->communities as $community) {
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td colspan="2">';
        if ($this->acl('communities', 'view')) {
            echo '<a href="' . $this->url(array('community' => $community->url), 'communities_community_view') . '">';
            echo '<b>' . $community->label . '</b>';
            echo '</a>';
        } else {
            echo '<b>' . $community->label . '</b>';
        }
        echo '&nbsp;';
        if ($community->amAuthor()) {
            echo '<b><i>[<a href="' . $this->url(array('community' => $community->url), 'communities_community_edit') . '">Editar</a>]</i></b>';
        }
        if ($this->acl('communities', 'enter')) {
            if (!$community->amModerator() && !$community->amMember()) {
                echo '[<a href="' . $this->url(array('community' => $community->url), 'communities_community_join') . '">Unirse</a>]';
            } else if (!$community->amAuthor()) {
                echo '[<a href="' . $this->url(array('community' => $community->url), 'communities_community_leave') . '">Retirarse</a>]';
            }
        }
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2"><b>Descripción: </b>' . $community->description . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2">';
        echo '<b>Etiquetas: </b>';

        $tags = $community->getTags();
        foreach ($tags as $tag) {
            echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
        }
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="300px"><b>Modalidad: </b>' . $this->mode(NULL, $community->mode) . '</td>';
        echo '<td><b>Miembros: </b>' . $community->members . '</td>';
        echo '</tr>';
        echo '</table>';
    }
    echo '<center>' . $this->paginator($this->communities, $this->route) . '</center>';
} else {
    echo '<p>No existen communidades registradas</p>';
}
