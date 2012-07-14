<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Nombre de materia (*):</b></td>';
echo '<td><input type="text" name="label" value="' . $this->subject->label . '" maxlength="64" /></td></tr>';
echo '<tr><td><b>Moderador (*):</b></td>';
echo '<td>' . $this->moderator('moderator', 'moderator', $this->subject->moderator) . '</td></tr>';
echo '<tr><td><b>Codigo (*):</b></td>';
echo '<td><input type="text" name="code" value="' . $this->subject->code . '" maxlength="7" /></td></tr>';
echo '<tr><td><b>Visibilidad (*):</b></td>';
echo '<td>' . $this->visibility('visibility', 'visibility', $this->subject->visibility) . '</td></tr>';
echo '<tr><td colspan="2"><b>Descripción :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->subject->description . '</textarea></td></tr>';
echo '<tr><td colspan="2"><b>Areas a las que pertenece :</b></td></tr>';

    foreach ($this->areas as $area) {
        echo '<tr><td>' . $area->label . '</td>';
        echo '<td><input type="checkbox" name="areas[]" ' . (in_array($area->ident, $this->checks) ? 'checked="checked" ':'') . 'value="' . $area->ident . '" /></td></tr>';
    }
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Editar materia" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr></table></form>';
echo '</center>';
