<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<p>En esta pagina usted puede configurar algunos aspectos del comportamiento del sistema, como por ejemplo: su contraseña, las notificaciones, los boletines y otros dependiendo de los modulos que esten instalados.</p>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table><tr><td colspan="2"><b>Cambio de contraseña:</b></td>';
echo '</tr><tr><td>Nueva contraseña:</td>';
echo '<td><input type="password" name="password1" value="" /></td>';
echo '</tr><tr><td>Repita la contraseña nueva:</td>';
echo '<td><input type="password" name="password2" value="" /></td>';
echo '</tr><tr><td>&nbsp;</td><td>';
echo '<input type="submit" value="Actualizar" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
