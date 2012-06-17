<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Gestion (*):</b></td><td>';
echo '<input type="text" name="label" size="15" maxlength="64" value="' . $this->gestion->label . '" />';
echo '</td></tr><tr><td colspan="2">(*) Campos obligatorios.</td>';
echo '</tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Crear gestion" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form>';
echo '</center>';
