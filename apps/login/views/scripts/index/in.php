<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<p>Para acceder al sistema, debe colocar su nombre de usuario y la contraseña que le haya sido provista.</p>';

echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';

echo '<table width="50%">';
echo '<tr><td>Usuario:</td>';
echo '<td><input type="text" name="username" value="' . $this->values['username'] . '" maxlength="32" /></td>';
echo '</tr><tr><td>Contraseña:</td>';
echo '<td><input type="password" name="password" maxlength="32" /></td>';
echo '</tr><tr><td>&nbsp;</td><td><input type="submit" value="Ingresar" /></td></tr><tr><td>&nbsp;</td><td>';
echo '<a href="' . $this->url(array(), 'login_forgot') . '">Olvide mi contraseña</a>';
echo '</td></tr></table></form></center>';
