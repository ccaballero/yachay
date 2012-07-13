<?php

echo '<h1>' . $this->page->label . '</h1>';
if ($this->acl('resources', 'new')) {
    echo '[<a href="' . $this->url(array(), 'feedback_new') . '">Crear nueva sugerencia</a>]';
}
if (count($this->feedback)) {
    echo '<ul>';
    foreach ($this->feedback as $entry) {
        echo '<li>';
        echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_view') . '">' . $this->wrapper($entry->description, 20) . '</a>&nbsp;';
        if ($entry->getResource()->amAuthor()) {
            echo '<b><i>[<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_edit') . '">Editar</a>]</i></b>';
        }
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen sugerencias</p>';
}
