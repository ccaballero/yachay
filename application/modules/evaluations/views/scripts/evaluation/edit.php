<?php

echo '<h1>Editar criterio de evaluación</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Nombre del criterio (*):</b></td><td><input type="text" name="label" size="15" maxlength="64" value="' . $this->evaluation->label . '" /></td></tr>';
echo '<tr><td><b>Accesibilidad (*):</b></td><td>' . $this->accesibility('access', $this->evaluation->access) . '</td></tr>';
echo '<tr><td colspan="2"><b>Descripción :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->evaluation->description . '</textarea></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Editar criterio" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
