<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td><b>Conjunto (*):</b></td>';
echo '<td><input type="text" name="label" size="15" maxlength="64" value="' . $this->groupset->label . '" /></td>';
echo '</tr>';
echo '<tr><td colspan="2"><b>Grupos :</b></td></tr>';
echo '<tr>';
echo '<td colspan="2">';
if (count($this->subjects)) {
    foreach ($this->subjects as $subject) {
        echo '<b>' . $subject->label . '</b>';
        echo '<br />';
        foreach ($this->groups[$subject->ident] as $group) {
            echo '<input type="checkbox" name="groups[]" ' . (in_array($group->ident, $this->checks) ? 'checked="checked" ' : '') . 'value="' . $group->ident . '" />';
            echo '<a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a>';
            echo '<br />';
        }
    }
} else {
    echo '<p>No existen asignaciones suyas en ninguna materia.</p>';
}
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Guardar" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
