<?php

echo '<h1>Evaluación: ' . $this->evaluation->label;
if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) {
    echo '[<i><a href="' . $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_edit') . '">Editar</a></i>]';
}
echo '[<i><a href="' . $this->url(array(), 'evaluations_sandbox') . '">Formulas</a></i>]';
echo '</h1>';

echo '<b>Creada por: <i>' . $this->evaluation->getAuthor()->getFullName() . '</i></b><br />';
echo '<b>Accesibilidad: <i>' . $this->access($this->evaluation->access) . '</i></b><br />';
echo '<b>Usable: <i>' . $this->boolean($this->evaluation->useful) . '</i></b><br />';

echo '<p>' . $this->evaluation->description . '</p>';

echo '<h2>Calificaciones previstas';
if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) {
    echo '[<i><a href="' . $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_test_add') . '">Agregar</a></i>]';
}
echo '</h2>';

if (count($this->tests_evaluation)) {
    echo '<dl>';
    foreach ($this->tests_evaluation as $test) {
        echo '<dt>';
        echo '<b>[' . $test->key . ']&nbsp;<a href="' . $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') . '">' . $test->label . '</a></b>';
        if ($test->formula) {
            echo ': ' . $test->formula;
        }
        if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) {
            echo '[<i><a href="' . $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') . '">Eliminar</a></i>]';
        }
        echo '</dt>';
        echo '<dd>';
        echo '<b>Nota minima: </b>' . $test->minimumnote . '<br />';
        echo '<b>Nota por omision: </b>' . $test->defaultnote . '<br />';
        echo '<b>Nota maxima: </b>' . $test->maximumnote . '<br />';
        echo '</dd>';
    }
    echo '</dl>';
} else {
    echo '<p>No se registraron calificaciones previstas.</p>';
}

echo '<h2>Grupos en los que ha sido implementado</h2>';
if (count($this->groups)) {
    echo '<ul>';
    foreach ($this->groups as $group) {
        echo '<li>';

        $subject = $group->getSubject();
        $gestion = $subject->getGestion();

        echo "[{$gestion->label}] {$subject->label} <b>Grupo {$group->label}</b>";
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No se ha implementado en ningun grupo aún.</p>';
}
