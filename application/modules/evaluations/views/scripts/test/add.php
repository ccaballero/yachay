<?php

echo '<h1>' . $this->evaluation->label;
echo '[<i><a href="' . $this->url(array(), 'evaluations_sandbox') . '">Formulas</a></i>]';
echo '</h1>';
echo '<h2>Nueva calificación</h2>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Nombre de la calificacion (*):</b></td><td><input type="text" name="label" value="' . $this->test_evaluation->label . '" maxlength="64" /></td></tr>';
echo '<tr><td><b>Codigo a utilizar (*):</b></td><td><input type="text" name="key" value="' . $this->test_evaluation->key . '" maxlength="4" /></td></tr>';
echo '<tr><td><b>Nota minima :</b></td><td><input type="text" name="minimum" value="' . $this->test_evaluation->minimumnote . '" maxlength="3" /></td></tr>';
echo '<tr><td><b>Nota por omision :</b></td><td><input type="text" name="default" value="' . $this->test_evaluation->defaultnote . '" maxlength="3" /></td></tr>';
echo '<tr><td><b>Nota maxima :</b></td><td><input type="text" name="maximum" value="' . $this->test_evaluation->maximumnote . '" maxlength="3" /></td></tr>';
echo '<tr><td><b>Formula de calculo (**):</b></td><td><input type="text" name="formula" value="' . $this->test_evaluation->formula . '" maxlength="512" /></td></tr>';
echo '<tr><td><b>Orden de precedencia :</b></td><td><input type="text" name="order" value="' . $this->test_evaluation->order . '" maxlength="3" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td colspan="2">(**) Si no se establece, se considera una entrada.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Agregar calificación" /> <a href="' . $this->lastPage() . '">Volver</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
echo '<h2>Calificaciones registradas</h2>';
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
