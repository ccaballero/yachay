<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('pages', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'pages_list')  . '">Lista</a>]</td>';
}
if ($this->acl('pages', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->pages)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>' . $this->model_pages->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['package'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['title'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['menutype'] . '</th>';
    echo '<th>' . $this->model_pages->_mapping['menuorder'] . '</th>';
    echo '</tr>';

    foreach ($this->pages as $page) {
        echo '<tr><td>';
        echo '<a target="_BLANK" href="' . $this->url(array(), $page->route) . '">' . $page->label . '</a>';
        echo '</td>';
        echo '<td>' . $page->package . '</td>';
        echo '<td><input type="text" name="pages[' . $page->ident . '][title]" value="' . $page->title . '" /></td>';
        echo '<td>' .$this->menutype('pages[' . $page->ident . '][menutype]', $page->menutype) . '</td>';
        echo '<td><center><input type="text" name="pages[' . $page->ident . '][menuorder]" size="2" maxlength="2" value="' . $page->menuorder . '" /></center></td>';
        echo '</tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No existen paginas registradas</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('pages', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'pages_list')  . '">Lista</a>]</td>';
}
if ($this->acl('pages', 'manage')) {
    echo '<td><input type="submit" value="Actualizar" /></td>';
}
echo '</tr></table>';
echo '</form>';
