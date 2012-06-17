<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Publicar en (*):</b></td><td>' . $this->context('publish') . '</td></tr>';
echo '<tr><td colspan="2"><b>Mensaje (*):</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="message" cols="50" rows="5">' . $this->note->note . '</textarea></td></tr>';
echo '<tr><td><b>Etiquetas (**):</b></td><td><input name="tags" value="' . $this->tags .'" maxlength="128" /></td></tr>';
echo '<tr><td>Convertir en Aviso</td><td><input type="checkbox" name="priority"/></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Crear nota" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
