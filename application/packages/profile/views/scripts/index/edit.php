<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<p>En esta pagina usted debe establecer la informacion que es solicitada, asegurese de mantenerla siempre actualizada, para no tener problemas en el uso del sistema.</p>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr>';
echo '<td><b>Nombre de usuario (*):</b></td>';
echo '<td><input type="text" name="label" value="' . $this->user->label . '" maxlength="20" /></td></tr><tr>';
echo '<td><b>Correo electronico:</b></td>';
echo '<td><input type="text" name="email" value="' . $this->user->email . '" maxlength="50" /></td></tr><tr>';
echo '<td><b>Apellidos:</b></td>';
echo '<td><input type="text" name="surname" value="' . $this->user->surname . '" maxlength="128" /></td></tr><tr>';
echo '<td><b>Nombres:</b></td>';
echo '<td><input type="text" name="name" value="' . $this->user->name . '" maxlength="128" /></td></tr><tr>';
echo '<td><b>Fecha de nacimiento:</b></td>';
echo '<td>' . $this->date('birthdate', $this->user->birthdate, 'BEFORE') . '</td></tr><tr>';
echo '<td><b>Carrera:</b></td>';
echo '<td>' . $this->career('career', $this->user->career) . '</td></tr><tr>';
echo '<td><b>Telefono:</b></td>';
echo '<td><input type="text" name="phone" value="' . $this->user->phone . '" maxlength="64" /></td></tr><tr>';
echo '<td><b>Celular:</b></td>';
echo '<td><input type="text" name="cellphone" value="' . $this->user->cellphone . '" maxlength="64" /></td></tr><tr>';
echo '<td><b>Avatar (jpg, png, gif):</b></td>';
echo '<td>' . $this->formFile('file'). '</td></tr><tr>';
echo '<td><b>Etiquetas (**):</b></td>';
echo '<td><input name="tags" value="' . $this->tags . '" maxlength="128" /></td></tr><tr>';
echo '<td><b>Pasatiempos:</b></td>';
echo '<td><input type="text" name="hobbies" value="' . $this->user->hobbies . '" maxlength="1024" /></td></tr><tr>';
echo '<td><b>Firma:</b></td>';
echo '<td><input type="text" name="sign" value="' . $this->user->sign . '" maxlength="1024" /></td></tr><tr>';
echo '<td colspan="2"><b>Descripcion personal:</b></td></tr><tr>';
echo '<td colspan="2"><textarea name="description" cols="50" rows="5">' . $this->user->description . '</textarea></td></tr><tr>';
echo '<td colspan="2">(*) Campos obligatorios.</td></tr><tr>';
echo '<td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Actualizar" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';