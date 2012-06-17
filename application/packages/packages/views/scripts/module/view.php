<?php

echo '<h1>Modulo: ' . $this->package->label . '</h1>';
echo '<i><b>Estado:</b> ' . $this->status($this->package->status) . '</i>';
echo '<br />';
echo '<i><b>Tipo:</b> ' . $this->type($this->package->type) . '</i>';

echo '<p>' . $this->package->description . '</p>';

echo '<h2>Rutas registradas</h2>';

if (isset($this->routes)) {
    echo '<center><table border="1" width="100%"><tr>';
    echo '<th>' . $this->model_pages->_mapping['route'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['package'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['controller'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['action'] . '</th>';
    echo '<th>Url</th>';
    echo '</tr>';

    foreach($this->routes->routes as $label => $route) {
        echo '<tr>';
        echo '<td>' . $label . '</td>';
        echo '<td>' . $route[1]['package'] . '</td>';
        echo '<td>' . $route[1]['controller'] . '</td>';
        echo '<td>' . $route[1]['action'] . '</td>';
        echo '<td>' . $route[0] . '</td>';
        echo '</tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No se registraron rutas para este modulo.</p>';
}
