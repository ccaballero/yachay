<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<center><table width="100%"><tr><th>Widget</th><th>1ª Posición</th><th>2ª Posición</th><th>3ª Posición</th><th>4ª Posición</th></tr>';

foreach ($this->pages as $page) {
    echo '<tr>';
    echo '<td>' . $page->label . '</td>';
    echo '<td><center>' . $this->widgets_pages[$page->ident]['1']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_pages[$page->ident]['2']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_pages[$page->ident]['3']->label . '</center></td>';
    echo '<td><center>' . $this->widgets_pages[$page->ident]['4']->label . '</center></td>';
    echo '</tr>';
}

echo '</table></center>';
