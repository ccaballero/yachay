<?php

echo '<h1>Carrera: ' . $this->career->label . '</h1>';

echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Nombre de la carrera (*):</b></td><td><input type="text" name="label" value="' . $this->career->label . '" size="20" maxlength="64" /></td></tr>';
echo '<tr><td colspan="2"><b>Descripción :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->career->description . '</textarea></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Editar carrera" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
