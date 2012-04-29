<?php

echo '<h1>Area: ' . $this->area->label;
if ($this->acl('areas', 'edit')) {
    echo '[<i><a href="' . $this->url(array('area' => $this->area->url), 'areas_area_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<p>' . $this->area->description . '</p>';
echo '<h2>Materias registradas</h2>';
if (count($this->subjects)) {
    echo '<ul>';
    foreach ($this->subjects as $subject) {
        echo '<li>';
        echo '<b><a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_view') . '">' . $subject->label . '</a></b>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No se registraron materias aún.</p>';
}

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, ));
