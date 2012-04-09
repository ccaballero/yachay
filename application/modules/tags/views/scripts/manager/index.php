<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table><tr>';
if ($this->acl('tags', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'tags_list') . '">Lista</a>]</td>';
}
if ($this->acl('tags', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->tags)) {
    echo '<table width="100%">';
    echo '<tr><th>&nbsp;</th><th>' . $this->model_tags->_mapping['label'] . '</th><th>' . $this->model_tags->_mapping['weight'] . '</th><th>Opciones</th><th>' . $this->model_tags->_mapping['tsregister'] . '</th></tr>';
    foreach ($this->tags as $tag) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="check[]" value="' . $tag->ident . '" /></td><td>' . $tag->label . '</td><td><center>' . $tag->weight . '</center></td>';
        echo '<td><center>';
        if ($this->acl('tags', 'list')) {
            echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '">Ver</a>';
        }
        if ($this->acl('tags', 'delete')) {
            echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_delete') . '">Eliminar</a>';
        }
        echo '</center></td>';
        echo '<td><center>' . $this->timestamp($tag->tsregister) . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No existen etiquetas registradas</p>';
}
echo '<hr />';

echo '<table><tr>';
if ($this->acl('tags', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'tags_list') . '">Lista</a>]</td>';
}
if ($this->acl('tags', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
echo '</tr></table>';
echo '</form>';
