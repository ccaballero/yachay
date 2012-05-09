<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr>';
echo '<td><b>Archivo (.zip) (2 MiB max.) (*):</b></td><td>';
echo $this->formFile('file');
echo '</td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr>';
echo '<td>&nbsp;</td><td><input type="submit" value="Instalar modulo" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
