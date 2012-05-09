<?php

echo '<h1>Sugerencia';
if ($this->resource->amAuthor()) {
    echo '[<i><a href="' . $this->url(array('entry' => $this->resource->ident), 'feedback_entry_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<table width="100%">';
echo '<tr>';
echo '<td valign="top">';
echo '<b>Autor: </b>';
echo '<i>';
if ($this->acl('users', 'view')) {
    echo '<a href="' . $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') . '">' . $this->resource->getAuthor()->label . '</a>';
} else {
    echo $this->resource->getAuthor()->label;
}
echo '</i>';
echo '</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td>';
echo '<b>Etiquetas: </b>';
foreach ($this->tags as $tag) {
    echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
}
echo '</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td>';
echo '<b>Valoración: </b>';
if ($this->acl('ratings', 'new')) {
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'feedback_entry_rating_down') . '"><b>&laquo;</b></a>';
}
echo '<i>' . $this->resource->ratings . ' / ' . $this->resource->raters . '</i>';
if ($this->acl('ratings', 'new')) {
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'feedback_entry_rating_up') . '"><b>&raquo;</b></a>';
}
echo '</td>';
echo '</tr>';
echo '<tr valign="top"><td><b>Fecha: </b><i>' . $this->timestamp($this->resource->tsregister) . '</i></td></tr>';
echo '</table>';

echo '<p>' . $this->specialEscape($this->escape($this->entry->description)) . '</p>';

if ($this->acl('comments', 'view')) {
    echo '<h2>Comentarios</h2>';
    echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'notes_note_comment', 'config' => $this->config, 'template' => $this->template));
    if ($this->acl('comments', 'new')) {
        echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'notes_note_comment', 'config' => $this->config, 'template' => $this->template));
    }
}
