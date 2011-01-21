<?php

$resource = $this->resource;
$comments = $resource->findComments();

if (count($comments)) {
    echo '<table width="100%">';
    foreach ($comments as $comment) {
        $author = $comment->getAuthor();
        echo '<tr><td valign="top"><b>' . $author->label . '</b>:</td><td valign="top" align="right">' . $this->timestamp($comment->tsregister) . '</td></tr>';
        echo '<tr><td colspan="2" valign="top">' . $comment->comment . '</td></tr>';
        echo '<tr><td>';
        if ($comment->amAuthor()) {
            echo '[<a href="' . $this->url(array('resource' => $resource->ident, 'comment' => $comment->ident), $this->route . '_delete') . '">Eliminar</a>]';
        } else if ($this->acl('comments', 'drop')) {
            echo '[<a href="' . $this->url(array('comment' => $comment->ident), 'comments_drop') . '">Eliminar</a>]';
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se registraron comentarios aún.</p>';
}
