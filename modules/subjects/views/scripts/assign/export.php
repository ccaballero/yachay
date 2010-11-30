<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Formato de archivo (*):</b></td><td>';
echo '<select name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select>';
echo '</td></tr><tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Exportar miembros" /><a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
