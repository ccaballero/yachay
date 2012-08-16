<?php

if ($this->note->priority) {
    echo '<h1>Aviso ';
    if ($this->resource->amAuthor()) {
	echo '[<i><a href="' . $this->url(array('note' => $this->resource->ident), 'notes_note_edit') . '">Editar</a></i>]';
    }
    echo '</h1>';
} else {
    echo '<h1>Nota ';
    if ($this->resource->amAuthor()) {
        echo '[<i><a href="' . $this->url(array('note' => $this->resource->ident), 'notes_note_edit') . '">Editar</a></i>]';
    }
    echo '</h1>';
}

echo '<table><tr><td valign="top"><b>Autor: </b><i>';
if ($this->acl('users', 'view')) {
    echo '<a href="' . $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') . '">' . $this->resource->getAuthor()->label . '</a>';
} else {
    echo $this->resource->getAuthor()->label;
}
echo '</i></td></tr>';
echo '<tr valign="top"><td><b>Publicado en: </b><i>' . $this->recipient($this->resource->recipient) . '</i></td></tr>';
echo '<tr valign="top"><td><b>Etiquetas: </b>';

foreach ($this->tags as $tag) {
    echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
}
echo '</td></tr>';
echo '<tr valign="top"><td><b>Valoración: </b>';
if ($this->acl('ratings', 'new')) {
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_down') . '"><b>&laquo;</b></a>';
}
echo '<i>' . $this->resource->ratings . ' / ' . $this->resource->raters . '</i>';
if ($this->acl('ratings', 'new')) {
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_up') . '"><b>&raquo;</b></a>';
}
echo '</td></tr>';
echo '<tr valign="top"><td><b>Fecha: </b><i>' . $this->timestamp($this->resource->tsregister) . '</i></td></tr>';
echo '</table>';

echo '<p>' . $this->specialEscape($this->escape($this->note->note)) . '</p>';

if ($this->acl('comments', 'view')) {
    echo '<h2>Comentarios</h2>';
    echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'comment_route' => 'notes_note_comment', 'config' => $this->config, 'template' => $this->template));
    if ($this->acl('comments', 'new')) {
        echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'comment_route' => 'notes_note_comment', 'config' => $this->config, 'template' => $this->template));
    }
}
