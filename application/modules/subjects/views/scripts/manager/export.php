<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Formato de archivo (*):</b></td><td>';
echo '<select name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></td></tr><tr>';
echo '<td colspan="2"><b>Seleccione los atributos que desea exportar</b></td></tr><tr>';
echo '<td>' . $this->model_subjects->_mapping['code'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="code" /></td></tr><tr>';
echo '<td>' . $this->model_subjects->_mapping['moderator'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="moderator" /></td></tr><tr>';
echo '<td>' . $this->model_subjects->_mapping['label'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="label" /></td></tr><tr>';
echo '<td>' . $this->model_subjects->_mapping['visibility'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="visibility" /></td></tr><tr>';
echo '<td>' . $this->model_subjects->_mapping['description'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="description" /></td></tr><tr>';
echo '<td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Exportar materias" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr></table>';
echo '</form></center>';
