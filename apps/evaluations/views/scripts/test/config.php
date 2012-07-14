<?php

echo '<h1>' . $this->evaluation->label . '</h1>';
echo '<h2>[' . $this->test_evaluation->key . ']&nbsp;' . $this->test_evaluation->label . '</h2>';
echo '<p>';
if ($this->test_evaluation->formula) {
    echo '<b>Formula: </b>' . $this->test_evaluation->formula . '<br />';
}
echo '<b>Nota minima: </b>' . $this->test_evaluation->minimumnote . '<br />';
echo '<b>Nota por omision: </b>' . $this->test_evaluation->defaultnote . '<br />';
echo '<b>Nota maxima: </b>' . $this->test_evaluation->maximumnote;
echo '</p>';
echo '<h2>Valores cualitativos</h2>';
if (count($this->test_values_evaluation)) {
    echo '<ul>';
    foreach ($this->test_values_evaluation as $value) {
        echo '<li>';
        echo '<b>[' . $value->label . ']&nbsp;</b>' . $value->value;
        if ($this->evaluation->author == $this->user->ident && count($this->groups) == 0) {
            echo '[<i><a href="' . $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $this->test_evaluation->ident, 'value' => $value->ident), 'evaluations_evaluation_test_value_delete') . '">Eliminar</a></i>]';
        }
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No se registraron valores cualitativos.</p>';
}
echo '<h3>Crear nuevo valor cualitativo</h3>';
echo '<center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Valor cualitativo (*):</b></td><td><input type="text" name="label" value="' . $this->test_value_evaluation->label . '" maxlength="64" /></td></tr>';
echo '<tr><td><b>Nota que representa (*):</b></td><td><input type="text" name="value" value="' . $this->test_value_evaluation->value . '" maxlength="3" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Agregar valor" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</center>';
