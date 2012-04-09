<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<p>Escriba su dirección de correo electrónico para que le enviemos una nueva contraseña.</p>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table width="50%"><tr><td>Correo electrónico:</td>';
echo '<td><input type="text" name="email" value="' . $this->values['email'] . '" maxlength="64" /></td>';
echo '</tr><tr><td>&nbsp;</td><td><input type="submit" value="Enviar" /></td></tr></table></form></center>';
