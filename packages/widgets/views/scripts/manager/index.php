<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('widgets', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'widgets_list') . '">Lista</a>]</td>';
}
if ($this->acl('widgets', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->pages)) {
    echo '<center><table width="100%"><tr><th>Widget</th><th>1&deg; Posici&oacute;n</th><th>2&deg; Posici&oacute;n</th><th>3&deg; Posici&oacute;n</th><th>4&deg; Posici&oacute;n</th></tr>';
    foreach ($this->pages as $page) {
        echo '<tr>';
        echo '<td>' . $page->label . '</td>';
        echo '<td><center>' . $this->widget('widgets[' . $page->ident . '][1]', $this->widgets_pages[$page->ident]['1']) . '</center></td>';
        echo '<td><center>' . $this->widget('widgets[' . $page->ident . '][2]', $this->widgets_pages[$page->ident]['2']) . '</center></td>';
        echo '<td><center>' . $this->widget('widgets[' . $page->ident . '][3]', $this->widgets_pages[$page->ident]['3']) . '</center></td>';
        echo '<td><center>' . $this->widget('widgets[' . $page->ident . '][4]', $this->widgets_pages[$page->ident]['4']) . '</center></td>';
        echo '</tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen paginas registradas</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('widgets', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'widgets_list') . '">Lista</a>]</td>';
}
if ($this->acl('widgets', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';

echo '</form>';
