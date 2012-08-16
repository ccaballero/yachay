<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Formato de archivo (*):</b></td>';
echo '<td><select name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></td>';
echo '</tr><tr><td colspan="2"><b>Seleccione los atributos que desea exportar</b></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['code'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="code" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['formalname'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="formalname" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['role'] . '</td>';
echo '<td><input type="checkbox" name="columns[]" value="role" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['label'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="label" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['email'] . '</td>';
echo '<td><input type="checkbox" name="columns[]" value="email" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['surname'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="surname" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['name'] . '</td>';
echo '<td><input type="checkbox" checked="checked" name="columns[]" value="name" /></td></tr><tr>';
echo '<td>' . $this->model_users->_mapping['career'] . '</td>';
echo '<td><input type="checkbox" name="columns[]" value="career" /></td></tr><tr>';
echo '<td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Exportar usuarios" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
