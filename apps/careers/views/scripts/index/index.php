<?php

echo '<h1>' . $this->route->label . '</h1>';
if (count($this->careers)) {
    echo '<ul>';
    foreach ($this->careers as $career) {
        echo '<li>';
        if ($this->acl('careers', 'view')) {
            echo '<a href="' . $this->url(array('career' => $career->url), 'careers_career_view') . '"><b>' . $career->label . '</b></a>';
        } else {
            echo '<b>' . $career->label . '</b>';
        }
        echo '&nbsp;';
        if ($this->acl('careers', 'edit')) {
            echo '<b><i>[<a href="' . $this->url(array('career' => $career->url), 'careers_career_edit') . '">Editar</a>]</i></b>';
        }
        echo '<br /><i>' . $career->description . '</i>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen carreras registradas</p>';
}
