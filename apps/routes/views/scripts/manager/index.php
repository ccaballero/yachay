<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('routes', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'routes_list')  . '">Lista</a>]</td>';
}
if ($this->acl('routes', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->routes)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>Etiqueta</th>';
    echo '<th>Paquete</th>';
    echo '<th>Titulo</th>';
    echo '<th>Tipo</th>';
    echo '</tr>';

    foreach ($this->routes as $route) {
        echo '<tr><td>' . $route->route . '</td>';
        echo '<td>' . $route->module . '</td>';
        echo '<td><input type="text" name="routes[' . $route->ident . '][title]" value="' . $route->label . '" /></td>';
        echo '<td>' .$this->menutype('routes[' . $route->ident . '][type]', $route->type) . '</td>';
//        echo '<td><center><input type="text" name="pages[' . $page->ident . '][menuorder]" size="2" maxlength="2" value="' . $page->menuorder . '" /></center></td>';
        echo '</tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No existen paginas registradas</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('routes', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'routes_list')  . '">Lista</a>]</td>';
}
if ($this->acl('routes', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '</form>';
