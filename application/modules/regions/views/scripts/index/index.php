<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<center><table width="100%"><tr><th>Pagina</th><th>Busqueda</th><th>Menus</th><th>Tareas</th><th>Inferior</th></tr>';

foreach ($this->pages as $page) {
    echo '<tr>';
    echo '<td>' . $page->label . '</td>';
    echo '<td><center>' . $this->regions_pages[$page->ident]['search']->label . '</center></td>';
    echo '<td><center>' . $this->regions_pages[$page->ident]['menubar']->label . '</center></td>';
    echo '<td><center>' . $this->regions_pages[$page->ident]['toolbar']->label . '</center></td>';
    echo '<td><center>' . $this->regions_pages[$page->ident]['footer']->label . '</center></td>';
    echo '</tr>';
}

echo '</table></center>';
