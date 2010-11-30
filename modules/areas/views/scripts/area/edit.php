<?php

echo '<h1>Editar area</h1>';

echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Nombre de area (*):</b></td><td><input type="text" name="label" value="' . $this->area->label . '" maxlength="20" /></td></tr>';
echo '<tr><td colspan="2"><b>Descripción :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->area->description . '</textarea></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Editar area" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
