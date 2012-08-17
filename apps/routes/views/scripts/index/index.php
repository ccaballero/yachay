<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center><table width="100%"><tr>';
echo '<th>Ruta</th>';
echo '<th>Paquete</th>';
echo '<th>Etiqueta</th>';
echo '<th>Tipo</th>';
echo '</tr>';

foreach ($this->routes as $route) {
    echo '<tr>';
    echo '<td>' . $route->route . '</td>';
    echo '<td>' . $route->module . '</td>';
    echo '<td>' . $route->label . '</td>';
    echo '<td>' . $route->type . '</td>';
    echo '</tr>';
}

echo '</table></center>';
