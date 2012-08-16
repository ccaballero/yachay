<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Area (*):</b></td><td><input type="text" name="label" size="20" maxlength="64" value="' . $this->area->label . '" /></td></tr>';
echo '<tr><td colspan="2"><b>Descripción :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->area->description . '</textarea></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Crear area" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
