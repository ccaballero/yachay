<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('regions', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'regions_list') . '">Lista</a>]</td>';
}
if ($this->acl('regions', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->pages)) {
    echo '<center><table width="100%"><tr><th>Pagina</th><th>Busqueda</th><th>Menus</th><th>Tareas</th><th>Inferior</th></tr>';
    foreach ($this->pages as $page) {
        echo '<tr>';
        echo '<td>' . $page->label . '</td>';
        echo '<td><center>' . $this->search('regions[' . $page->ident . '][search]', $this->regions_pages[$page->ident]['search']) . '</center></td>';
        echo '<td><center>' . $this->menubar('regions[' . $page->ident . '][menubar]', $this->regions_pages[$page->ident]['menubar']) . '</center></td>';
        echo '<td><center>' . $this->toolbar('regions[' . $page->ident . '][toolbar]', $this->regions_pages[$page->ident]['toolbar']) . '</center></td>';
        echo '<td><center>' . $this->footer('regions[' . $page->ident . '][footer]', $this->regions_pages[$page->ident]['footer']) . '</center></td>';
        echo '</tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen paginas registradas</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('regions', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'regions_list') . '">Lista</a>]</td>';
}
if ($this->acl('regions', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';

echo '</form>';
