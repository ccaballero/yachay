<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'feedback_list') . '">Lista</a>]</td>';
echo '<td>[<a href="' . $this->url(array(), 'feedback_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" name="mark" value="Marcar" /></td>';
echo '<td><input type="submit" name="unmark" value="Desmarcar" /></td>';
echo '<td><input type="submit" name="resolv" value="Resuelto" /></td>';
echo '<td><input type="submit" name="unresolv" value="No resuelto" /></td>';
echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
echo '</tr>';
echo '</table>';
echo '<hr />';
if (count($this->feedback)) {
    echo '<table width="100%">';
    echo '<tr><th>&nbsp;</th><th>' . $this->model_feedback->_mapping['description'] . '</th><th>Opciones</th><th>' . $this->model_feedback->_mapping['tsregister'] . '</th></tr>';
    foreach ($this->feedback as $entry) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="check[]" value="' . $entry->resource . '" /></td>';
        echo '<td>' . $this->wrapper($entry->description) . '</td>';
        echo '<td><center>';
        echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_view') . '">Ver</a>';
        if ($entry->resolved) {
            echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_unresolv') . '">No resuelto</a>';
        } else {
            echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_resolv') . '">Resuelto</a>';
        }
        if ($entry->mark) {
            echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_unmark') . '">Desmarcar</a>';
        } else {
            echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_mark') . '">Marcar</a>';
        }
        echo '<a href="' . $this->url(array('entry' => $entry->resource), 'feedback_entry_drop') . '">Eliminar</a>';
        echo '</center></td>';
        echo '<td><center>' . $this->timestamp($entry->getResource()->tsregister) . '</center></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No existen sugerencias</p>';
}
echo '<hr />';
echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'feedback_list') . '">Lista</a>]</td>';
echo '<td>[<a href="' . $this->url(array(), 'feedback_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" name="mark" value="Marcar" /></td>';
echo '<td><input type="submit" name="unmark" value="Desmarcar" /></td>';
echo '<td><input type="submit" name="resolv" value="Resuelto" /></td>';
echo '<td><input type="submit" name="unresolv" value="No resuelto" /></td>';
echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
