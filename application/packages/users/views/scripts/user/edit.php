<?php 

echo '<h1>Editar usuario: ' . $this->user->label . '</h1>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';

echo '<table><tr><td><b>Nombre de usuario (*):</b></td>';
echo '<td><input type="text" name="label" value="' . $this->user->label . '" maxlength="20" /></td>';
echo '</tr><tr><td><b>Codigo SISS :</b></td>';
echo '<td><input type="text" name="code" value="' . $this->user->code . '" maxlength="9" /></td>';
echo '</tr><tr><td><b>Nombre Formal :</b></td>';
echo '<td><input type="text" name="formal" value="' . $this->user->formalname . '" maxlength="128" /></td></tr>';

if ($this->me->ident <> $this->user->ident) {
    echo '<tr><td><b>Rol (*):</b></td>';
    echo '<td>' . $this->role('role', $this->user->role) . '</td></tr>';
}

echo '<tr><td><b>Correo electronico:</b></td>';
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
echo '<td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Guardar" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
