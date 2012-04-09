<?php

echo '<h1>Calificaciones: Grupo ' . $this->group->label . '</h1>';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i><br /><br />';
echo '<b>Dictada por: <i>' . $this->group->getTeacher()->getFullName() . '</i></b><br />';
echo '<b>Estado: <i>' . $this->status($this->group->status) . '</i></b><br />';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr><td><input type="submit" value="Guardar" name="save" /></td><td><input type="submit" value="Limpiar" name="clean" /></td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') . '">Importar</a>]</td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') . '">Exportar</a>]</td>';
echo '<td>&nbsp;|&nbsp;</td><td>' . $this->evaluation('evaluation', $this->group->evaluation) . '</td><td><input type="submit" value="Cambiar" name="change" /></td></tr>';
echo '</table>';
echo '<hr />';
if (count($this->students) != 0) {
    echo '<table width="100%"><tr><th>Estudiante</th>';
    foreach ($this->tests as $test) {
        echo '<th>' . $test->key . '</th>';
    }
    echo '</tr>';
    foreach ($this->students as $student) {
        echo '<tr><td>' . $student->formalname . '</td>';
        foreach ($this->tests as $test) {
            $hasformula = !empty($test->formula);
            echo '<td width="20px"><center>';
            if ($test->hasValues()) {
                echo '' . $this->testValues('calification[' . $this->group->ident . '][' . $student->ident . '][' . $this->evaluation->ident . '][' . $test->ident . ']', $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test), $test, $hasformula) . '';
            } else {
                echo '<input type="text" ' . $hasformula ? 'disabled="disabled" ':'' . 'maxlength="8" size="3" name="calification[' . $this->group->ident . '][' . $student->ident. '][' . $this->evaluation->ident. '][' . $test->ident . ']" value="' . $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test) . '" />';
            }
            echo '</center></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se encontraron estudiantes</p>';
}
echo '<hr />';
echo '<table>';
echo '<tr><td><input type="submit" value="Guardar" name="save" /></td><td><input type="submit" value="Limpiar" name="clean" /></td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') . '">Importar</a>]</td>';
echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') . '">Exportar</a>]</td>';
echo '<td>&nbsp;|&nbsp;</td><td>' . $this->evaluation('evaluation', $this->group->evaluation) . '</td><td><input type="submit" value="Cambiar" name="change" /></td></tr>';
echo '</table>';
echo '</form>';
