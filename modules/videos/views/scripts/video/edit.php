<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Proporción (*):</b></td><td>' . $this->proportion('proportion', 'proportion', $this->video->proportion) . '</td></tr>';
echo '<tr><td colspan="2"><b>Descripción (*):</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->video->description . '</textarea></td></tr>';
echo '<tr><td><b>Etiquetas (**):</b></td><td><input name="tags" value="' . $this->tags . '" maxlength="128" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Guardar" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
