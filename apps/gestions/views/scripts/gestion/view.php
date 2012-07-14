<?php

echo '<h1>Gestion: ' . $this->gestion->label . '</h1>';
echo '<h2>Materias registradas</h2>';

if (count($this->subjects)) {
    echo '<ul>';
    foreach ($this->subjects as $subject) {
        echo '<li>';
        echo '<b>[' . $subject->code . ']<i>&nbsp;<a href="' . $this->url(array('gestion' => $this->gestion->url, 'subject' => $subject->url), 'gestions_gestion_subject') . '">' . $subject->label . '</a></i></b>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No se registraron materias aún.</p>';
}
