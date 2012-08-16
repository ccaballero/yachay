<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table><tr><td>[<a href="' . $this->url(array(), 'groupsets_new') . '">Nuevo</a>]</td><td><input type="submit" name="delete" value="Eliminar" /></td></tr></table>';
echo '<hr />';

if (count($this->groupsets)) {
echo '<center>';
echo '<table width="100%">';
echo '<tr>';
echo '<th>&nbsp;</th>';
echo '<th>' . $this->model_groupsets->_mapping['label'] . '</th>';
echo '<th>Opciones</th>';
echo '<th>' . $this->model_groupsets->_mapping['tsregister'] . '</th>';
echo '</tr>';
foreach ($this->groupsets as $groupset) {
echo '<tr>';
echo '<td><input type="checkbox" name="check[]" value="' . $groupset->ident . '" /></td>';
echo '<td>' . $groupset->label . '</td>';
echo '<td>';
echo '<center>';
echo '<a href="' . $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_view') . '">Ver</a>';
echo '<a href="' . $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_edit') . '">Editar</a>';
echo '<a href="' . $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_delete') . '">Eliminar</a>';
echo '</center>';
echo '</td>';
echo '<td><center>' . $this->timestamp($groupset->tsregister) . '</center></td>';
echo '</tr>';
}
echo '</table>';
echo '</center>';
} else {
echo '<p>No existen conjuntos registradas</p>';
}
echo '<hr />';

echo '<table><tr><td>[<a href="' . $this->url(array(), 'groupsets_new') . '">Nuevo</a>]</td><td><input type="submit" name="delete" value="Eliminar" /></td></tr></table>';
echo '</form>';
