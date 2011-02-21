<?php

echo '<h1>Carrera: ' . $this->career->label;
if ($this->acl('careers', 'edit')) {
    echo '[<i><a href="' . $this->url(array('career' => $this->career->url), 'careers_career_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<p>' . $this->career->description . '</p>';
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

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, ));
