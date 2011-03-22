<?php

echo '<h1>Video ';
if ($this->resource->amAuthor()) {
    echo '[<i><a href="' . $this->url(array('video' => $this->resource->ident), 'videos_video_edit') . '">Editar</a></i>]';
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
    echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_down') . '"><b>&laquo;</b></a>';
}
echo '<i>' . $this->resource->ratings . ' / ' . $this->resource->raters . '</i>';
if ($this->acl('ratings', 'new')) {
echo '<a href="' . $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_up') . '"><b>&raquo;</b></a>';
}
echo '</td></tr>';
echo '<tr valign="top"><td><b>Fecha: </b><i>' . $this->timestamp($this->resource->tsregister) . '</i></td></tr>';
echo '</table>';

list($w, $h) = @split(':', $this->video->proportion);
$proportion = $w / $h;

echo '<center>';
echo '<object class="playerpreview" type="application/x-shockwave-flash" ';
echo 'data="' . $this->CONFIG->wwwroot . 'media/videos/flvplayer.swf" width="600" height="' . intval(600 / $proportion) . '">';
echo '<param name="movie" value="' . $this->CONFIG->wwwroot . 'media/videos/flvplayer.swf" />';
echo '<param name="allowFullScreen" value="true" />';
echo '<param name="FlashVars" value="flv=' . $this->CONFIG->wwwroot . 'media/videos/' . $this->video->resource;
echo '&showstop=1&showvolume=1&showtime=1&showfullscreen=1&buffermessage=Cargando...' . '" />';
echo '</object>';
echo '</center>';

echo '<p>' . $this->specialEscape($this->escape($this->video->description)) . '</p>';

if ($this->acl('comments', 'view')) {
    echo '<h2>Comentarios</h2>';
    echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, ));
    if ($this->acl('comments', 'new')) {
        echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER));
    }
}
