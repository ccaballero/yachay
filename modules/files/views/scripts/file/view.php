<?php

echo '<h1>Archivo ';
if ($this->resource->amAuthor()) {
    echo '[<i><a href="' . $this->url(array('file' => $this->resource->ident), 'files_file_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<table width="100%"><tr><td valign="top"><b>Autor: </b><i>';
if ($this->acl('users', 'view')) {
    echo '<a href="' . $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') . '">'. $this->resource->getAuthor()->label . '</a>';
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
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'files_file_rating_down') . '"><b>&laquo;</b></a>';
}
echo '<i>' . $this->resource->ratings . ' / ' . $this->resource->raters . '</i>';
if ($this->acl('ratings', 'new')) {
echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'files_file_rating_up') . '"><b>&raquo;</b></a>';
}
echo '</td></tr>';
echo '<tr valign="top"><td><b>Fecha: </b><i>' . $this->timestamp($this->resource->tsregister) . '</i></td></tr>';
echo '</table>';

echo '<p>' . str_replace(" ", "&nbsp;", str_replace("\n", "<br/>", $this->escape($this->file->description))) . '</p>';
echo '<center>' . $this->mime($this->file->mime) . '&nbsp;<a href="' . $this->url(array('file' => $this->file->resource), 'files_file_download') . '">' . $this->file->filename . '</a>&nbsp;' . $this->size($this->file->size) . '</center>';

if ($this->acl('comments', 'view')) {
    echo '<h2>Comentarios</h2>';
    echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'files_file_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, ));
    if ($this->acl('comments', 'new')) {
        echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'files_file_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER));
    }
}
