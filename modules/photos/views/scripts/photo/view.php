<?php

echo '<h1>Imagen ';
if ($this->resource->amAuthor()) {
    echo '[<i><a href="' . $this->url(array('photo' => $this->resource->ident), 'photos_photo_edit') . '">Editar</a></i>]';
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
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_down') . '"><b>&laquo;</b></a>';
}
echo '<i>' . $this->resource->ratings . ' / ' . $this->resource->raters . '</i>';
if ($this->acl('ratings', 'new')) {
echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_up') . '"><b>&raquo;</b></a>';
}
echo '</td></tr>';
echo '<tr valign="top"><td><b>Fecha: </b><i>' . $this->timestamp($this->resource->tsregister) . '</i></td></tr>';
echo '</table>';

echo '<p>' . $this->specialEscape($this->escape($this->photo->description)) . '</p>';
echo '<center><img src="' . $this->CONFIG->wwwroot . 'media/photos/' . $this->photo->resource . '" alt="" title="" /></center>';

if ($this->acl('comments', 'view')) {
    echo '<h2>Comentarios</h2>';
    echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, ));
    if ($this->acl('comments', 'new')) {
        echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER));
    }
}
