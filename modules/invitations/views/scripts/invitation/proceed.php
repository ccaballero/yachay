<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<p>Para finalizar el proceso de registro, debe escoger su nombre de usuario y sus datos personales.</p>';

echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';

echo '<table width="100%">';
echo '<tr><td><b>Nombre de usuario (*):</b></td>';
echo '<td><input type="text" name="label" value="' . $this->user->label . '" maxlength="20" /></td>';
echo '</tr><tr><td><b>Apellidos:</b></td>';
echo '<td><input type="text" name="surname" value="' . $this->user->surname . '" maxlength="128" /></td>';
echo '</tr><tr><td><b>Nombres:</b></td>';
echo '<td><input type="text" name="name" value="' . $this->user->name . '" maxlength="128" /></td>';
echo '</tr><tr><td><b>Fecha de nacimiento:</b></td>';
echo '<td>' . $this->date('birthdate', $this->user->birthdate, 'BEFORE') . '</td>';
echo '</tr><tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td><input type="submit" value="Registrar usuario" />';
echo '</td></tr></table></form></center>';
