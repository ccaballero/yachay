<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center><form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table width="100%"><tr><td>&nbsp;</td>';

foreach ($this->roles as $role) {
    echo '<td><b>' . $role->label . '</b></td>';
}
echo '</tr>';

foreach ($this->users as $user) {
    echo '<tr>';
    echo '<td><b>' . $user->label . '</b></td>';
    foreach ($this->roles as $role) {
        echo '<td><center>';
        echo '<input type="radio"' . ($user->role == $role->ident ? ' checked="checked" ' : ' ') . 'name="radio[' . $user->ident . ']" value="' . $role->ident . '" />';
        echo '</center></td>';
    }
    echo '</tr>';
}

echo '</table><input type="submit" value="Actualizar asignacion" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</form></center>';
