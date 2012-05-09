<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Publicar en (*):</b></td><td>' . $this->context('publish') . '</td></tr>';
echo '<tr><td><b>Archivo (.flv) (20 MiB max.) (*):</b></td><td>' . $this->formFile('video'). '</td></tr>';
echo '<tr><td><b>Proporción (*):</b></td><td>' . $this->proportion('proportion', 'proportion', $this->video->proportion). '</td></tr>';
echo '<tr><td colspan="2"><b>Descripción:</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->video->description . '</textarea></td></tr>';
echo '<tr><td><b>Etiquetas (**):</b></td><td><input name="tags" value="' . $this->tags . '" maxlength="128" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Subir video" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
