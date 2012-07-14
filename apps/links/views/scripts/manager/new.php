<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Publicar en (*):</b></td><td>' . $this->context('publish') . '</td></tr>';
echo '<tr><td><b>Enlace (*):</b></td><td><input name="link" value="' . $this->link->link .'" maxlength="128" /></td></tr>';
echo '<tr><td colspan="2"><b>Descripción:</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->link->description . '</textarea></td></tr>';
echo '<tr><td><b>Etiquetas (**):</b></td><td><input name="tags" value="' . $this->tags .'" maxlength="128" /></td></tr>';
echo '<tr><td>Convertir en Aviso</td><td><input type="checkbox" name="priority"/></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Crear enlace" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
