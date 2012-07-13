<?php

echo '<h1>Exportar miembros</h1>';

echo '<center>';
echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td><b>Formato de archivo (*):</b></td>';
echo '<td>';
echo '<select name="extension">';
echo '<option>--------------------------</option>';
echo '<option value="csv">.csv (Archivo separado por comas)</option>';
echo '</select>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2">(*) Campos obligatorios.</td>';
echo '</tr>';
echo '<tr>';
echo '<td>&nbsp;</td>';
echo '<td>';
echo '<input type="submit" value="Exportar miembros" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
echo '</center>';
