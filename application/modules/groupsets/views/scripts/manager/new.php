<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Conjunto (*):</b></td><td><input type="text" name="label" size="15" maxlength="64" value="' . $this->groupset->label . '" /></td></tr>';
echo '<tr><td colspan="2"><b>Grupos :</b></td></tr>';
echo '<tr><td colspan="2">';
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
echo '</tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr>';
echo '<td>&nbsp;</td>';
echo '<td><input type="submit" value="Crear conjunto" /> <a href="' . $this->lastPage() . '">Cancelar</a></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
echo '</center>';
