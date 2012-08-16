<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Nombre (*):</b></td><td><input type="text" name="name" value="' . $this->event->label . '"/></td></tr>';
echo '<tr><td><b>Lugar :</b></td><td><input type="text" name="place" value="' . $this->event->place . '"/></td></tr>';
echo '<tr><td><b>Fecha (*):</b></td><td>' . $this->time('event', $this->event->event) . '</td></tr>';
echo '<tr><td><b>Duración :</b></td><td>' . $this->interval('duration', 'interval', $this->event->duration) . '</td></tr>';
echo '<tr><td colspan="2"><b>Mensaje :</b></td></tr>';
echo '<tr><td colspan="2"><textarea name="message" cols="50" rows="5">' . $this->event->message . '</textarea></td></tr>';
echo '<tr><td><b>Etiquetas (**):</b></td><td><input name="tags" value="' . $this->tags . '" maxlength="128" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Las etiquetas deben separarse con comas.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Guardar" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
