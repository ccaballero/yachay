<?php

echo '<h1>Calificaciones: Grupo ' . $this->group->label . '</h1>';

echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';
echo '<br />';
echo '<br />';
echo '<b>Dictada por: <i>' . $this->group->getTeacher()->getFullName() . '</i></b>';
echo '<br />';
echo '<b>Estado: <i>' . $this->status($this->group->status) . '</i></b>';
echo '<br />';
echo '<b>Metodo de evaluación: <i>' . $this->group->getEvaluation()->label . '</i></b>';
echo '<br />';

echo '<table>';
echo '<tr>';
foreach ($this->test_evaluations as $test) {
    echo '<th>' . $test->label . '</th>';
}
echo '</tr>';
echo '<tr>';
foreach ($this->test_evaluations as $test) {
    echo '<td class="center">';
    if ($test->hasValues()) {
        echo $this->testValues(NULL, $this->model->getCalification($this->group->ident, $this->user->ident, $this->evaluation->ident, $test), $test, !empty($test->formula));
    } else {
        echo $this->califications[$test->ident];
    }
    echo '</td>';
}
echo '</tr>';
echo '</table>';
