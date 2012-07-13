<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center><form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';

echo '<table>';
echo '<tr><td><b>Correo electronico (*):</b></td><td><input type="text" name="email" value="' . $this->invitation->email . '" size="20" maxlength="64" /></td></tr>';
echo '<tr><td><b>Mensaje: </b></td><td><textarea name="message" cols="50" rows="5">' . $this->invitation->message . '</textarea></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr>';
echo '<td>&nbsp;</td><td><input type="submit" value="Crear invitación" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td></tr></table></form></center>';
