<?php

echo '<h2>Insertar nuevo comentario</h2>';
echo '<form method="post" action="' . $this->url(array('resource' => $this->resource->ident), $this->route) . '" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<textarea cols="100" rows="3" name="comment"></textarea>';
echo '<br />';
echo '<input type="submit" value="Comentar" />';
echo '</form>';
