<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
if (count($this->tags) <> 0) {
    foreach ($this->tags as $tag) {
        echo '<a href="' . $this->url(array('tag' => $tag['tag']->url), 'tags_tag_view') . '">';
        echo '<font size="' . ($tag['scale'] <= 3 ? 1 : $tag['scale'] - 3) . '">';
        echo $tag['tag']->label;
        echo '</font>';
        echo '</a>&nbsp;';
    }
} else {
    echo '<p>No se encontraron etiquetas</p>';
}
