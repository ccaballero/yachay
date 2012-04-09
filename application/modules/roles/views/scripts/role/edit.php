<?php

echo '<h1>Editar rol: ' . $this->role->label . '</h1>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Rol (*):</b></td>';
echo '<td><input name="label" type="text" value="' . $this->role->label . '" maxlength="50" /></td>';
echo '</tr><tr><td colspan="2"><b>Descripcion:</b></td></tr><tr><td colspan="2" align="right">';
echo '<textarea name="description" cols="50" rows="5">' . $this->role->description . '</textarea>';
echo '</td></tr><tr><td colspan="2"><b>Privilegios:</b></td></tr>';

foreach ($this->privileges as $privilege) {
    echo '<tr>';
    echo '<td><b>[' . $privilege->module . ']</b>&nbsp;' . $privilege->label . '</td>';
    echo '<td align="right">';
    echo '<input type="checkbox"' . (in_array($privilege->ident, $this->role_privilege) ? ' checked="checked" ' : ' ') . 'name="privileges[]" value="' . $privilege->ident . '" />';
    echo '</td></tr>';
}

echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td><input type="submit" value="Guardar" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
