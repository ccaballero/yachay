<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td><b>Nombre de usuario (*):</b></td>';
echo '<td><input type="text" name="label" value="' . $this->user->label . '" maxlength="20" /></td>';
echo '</tr><tr><td><b>Generador de contraseña:</b></td>';
echo '<td>' . $this->password('password', $this->user->password) . '</td>';
echo '</tr><tr><td><b>Codigo SISS (*):</b></td>';
echo '<td><input type="text" name="code" value="' . $this->user->code . '" maxlength="9" /></td>';
echo '</tr><tr><td><b>Nombre Formal (*):</b></td>';
echo '<td><input type="text" name="formal" value="' . $this->user->formalname . '" maxlength="128" /></td>';
echo '</tr><tr><td><b>Rol (*):</b></td>';
echo '<td>' . $this->role('role', $this->user->role) . '</td>';
echo '</tr><tr><td><b>Correo electrónico:</b></td>';
echo '<td><input type="text" name="email" value="' . $this->user->email . '" maxlength="50" /></td>';
echo '</tr><tr><td><b>Apellidos:</b></td>';
echo '<td><input type="text" name="surname" value="' . $this->user->surname . '" maxlength="128" /></td>';
echo '</tr><tr><td><b>Nombres:</b></td>';
echo '<td><input type="text" name="name" value="' . $this->user->name . '" maxlength="128" /></td>';
echo '</tr><tr><td><b>Fecha de nacimiento:</b></td>';
echo '<td>' . $this->date('birthdate', $this->user->birthdate) . '</td>';
echo '</tr><tr><td><b>Carrera:</b></td>';
echo '<td>' . $this->career('career', $this->user->career) . '</td>';
echo '</tr><tr><td><b>Telefono:</b></td>';
echo '<td><input type="text" name="phone" value="' . $this->user->phone . '" maxlength="64" /></td>';
echo '</tr><tr><td><b>Celular:</b></td>';
echo '<td><input type="text" name="cellphone" value="' . $this->user->cellphone . '" maxlength="64" /></td>';
echo '</tr><tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td><input type="submit" value="Crear usuario" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
