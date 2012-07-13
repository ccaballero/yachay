<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8"><input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('careers', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'careers_list') . '">Lista</a>]</td>';
}
if ($this->acl('careers', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'careers_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';

echo '<hr />';
if (count($this->careers)) {
    echo '<center><table width="100%">';
    echo '<tr><th>' . $this->model_careers->_mapping['label'] . '</th><th>Opciones</th><th>' . $this->model_careers->_mapping['tsregister'] . '</th></tr>';
    foreach ($this->careers as $career) {
        echo '<tr><td>' . $career->label . '</td><td><center>';
        if ($this->acl('careers', 'view')) {
            echo '<a href="' . $this->url(array('career' => $career->url), 'careers_career_view') . '">Ver</a> ';
        }
        if ($this->acl('careers', 'edit')) {
            echo '<a href="' . $this->url(array('career' => $career->url), 'careers_career_edit') . '">Editar</a> ';
        }
        if ($this->acl('careers', 'delete')) {
            if ($career->isEmpty()) {
                echo '<a href="' . $this->url(array('career' => $career->url), 'careers_career_delete') . '">Eliminar</a>';
            }
        }
        echo '</center></td><td><center>' . $this->timestamp($career->tsregister) . '</center></td></tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen carreras registradas</p>';
}
echo '<hr />';

echo '<table><tr>';
if ($this->acl('careers', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'careers_list') . '">Lista</a>]</td>';
}
if ($this->acl('careers', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'careers_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';

echo '</form>';
