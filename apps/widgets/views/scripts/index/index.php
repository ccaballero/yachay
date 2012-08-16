<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center><table width="100%"><tr><th>Ruta</th><th>1ª Posición</th><th>2ª Posición</th><th>3ª Posición</th><th>4ª Posición</th></tr>';

foreach ($this->routes as $route) {
    echo '<tr>';
    echo '<td>' . $route->label . '</td>';
    echo '<td><center>' . $this->widgets_routes[$route->ident]['1']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_routes[$route->ident]['2']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_routes[$route->ident]['3']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_routes[$route->ident]['4']->label . '</center></td>';
    echo '</tr>';
}

echo '</table></center>';
