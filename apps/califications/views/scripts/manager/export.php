<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Formato de archivo (*):</b></td><td><select name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></td></tr>';
echo '<tr><td colspan="2"><b>Seleccione los valores que desea exportar</b></td></tr>';
foreach ($this->tests as $test) {
    echo '<tr><td><b>[' . $test->key . ']</b>&nbsp;' . $test->label . '</td><td><input type="checkbox" checked="checked" name="columns[]" value="' . $test->key . '" /></td></tr>';
}
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Exportar calificaciones" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
