<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'communities_list') . '">Lista</a>]</td>';
echo '<td>[<a href="' . $this->url(array(), 'communities_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
echo '</tr>';
echo '</table>';

echo '<hr />';
if (count($this->communities)) {
echo '<center>';
echo '<table width="100%">';
echo '<tr>';
echo '<th>&nbsp;</th>';
echo '<th>' . $this->model_communities->_mapping['label'] . '</th>';
echo '<th>' . $this->model_communities->_mapping['mode'] . '</th>';
echo '<th>' . $this->model_communities->_mapping['members'] . '</th>';
echo '<th>Opciones</th>';
echo '<th>' . $this->model_communities->_mapping['tsregister'] . '</th>';
echo '</tr>';
foreach ($this->communities as $community) {
echo '<tr>';
echo '<td><input type="checkbox" name="check[]" value="' . $community->ident . '" /></td>';
echo '<td>' . $community->label . '</td>';
echo '<td><center>' . $this->mode(NULL, $community->mode) . '</center></td>';
echo '<td><center>' . $community->members . '</center></td>';
echo '<td>';
echo '<center>';
echo '<a href="' . $this->url(array('community' => $community->url), 'communities_community_view') . '">Ver</a> ';
echo '<a href="' . $this->url(array('community' => $community->url), 'communities_community_edit') . '">Editar</a> ';
echo '<a href="' . $this->url(array('community' => $community->url), 'communities_community_delete') . '">Eliminar</a>';
echo '</center>';
echo '</td>';
echo '<td><center>' . $this->timestamp($community->tsregister) . '</center></td>';
echo '</tr>';
}
echo '</table>';
echo '</center>';
} else {
echo '<p>No existen comunidades registradas</p>';
}
echo '<hr />';

echo '<table>';
echo '<tr>';
echo '<td>[<a href="' . $this->url(array(), 'communities_list') . '">Lista</a>]</td>';
echo '<td>[<a href="' . $this->url(array(), 'communities_new') . '">Nuevo</a>]</td>';
echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
