<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if ($this->step == 1) {

    echo '<p>Para importar materias se toman en cuenta las siguientes filas:</p>';
    echo '<ul><li>Código (Imprescindible)</li><li>Materia (Imprescindible)</li><li>Moderador (Debe tener permiso de moderador)</li><li>Visibilidad (Los valores posibles son \'public\', \'register\', \'private\', el valor por omision es \'private\')</li><li>Descripción</li></ul>';

    echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
    echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
    echo '<table><tr><td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>';
    echo '<td>' . $this->formFile('file'). '</td></tr>';

    $first = true;
    foreach ($this->options as $key => $option) {
        echo '<tr><td>' . $option . '</td>';
        echo '<td><input type="radio" ' . ($first ? 'checked="checked" ':'') . 'name="type" value="' . $key . '"/></td></tr>';
        $first = false;
    }
    echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td>';
    echo '<input type="submit" value="Importar materias" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
    echo '</td></tr></table></form>';

} else {

    echo '<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>';

    echo '<form method="post" action="" accept-charset="utf-8">';
    echo '<a href="' . $this->url(array(), 'subjects_import') . '">Subir nuevamente</a> <input type="submit" value="Importar materias" /><hr />';
    echo '<p><b>Modalidad: </b>' . $this->options[$this->type] . '</p>';
    echo '<table width="100%">';

    foreach ($this->results as $results) {
        echo '<tr><td rowspan="4" valign="top" width="18px">';
        echo '<input type="checkbox" name="subjects[]" ' . (($results['CHECKED'] && isset($results['MODERADOR_OBJ'])) ? 'checked="checked" ' : '') . ' value="' . $results['CODIGO']. '" /></td>';
        echo '<td><b>[' . $results['CODIGO'] . '] ' . $results['MATERIA'] . '</b></td><td align="right">';

        if ($results['CODIGO_NUE']) {
            echo '[NUEVO]&nbsp;';
            if ($this->acl('subjects', 'new')) {
                echo '<b>[OK]</b>';
            } else {
                echo 'No tienes permiso para crear materias.&bnsp;<b>FALLO</b>';
            }
        } else {
            echo '<a href="' . $this->url(array('subject' => $results['MATERIA_OBJ']->url), 'subjects_subject_view') . '" target="_BLANK">Ver Materia</a>';
            echo '&nbsp;[EDICION]&nbsp;';
            if ($this->acl('subjects', 'edit')) {
                echo '<b>[OK]</b>';
            } else {
                echo 'No tienes permiso para editar materias.&nbsp;<b>FALLO</b>';
            }
        }

        echo '</td></tr><tr><td><b>Moderador: </b>' . $results['MODERADOR'] . '</td><td align="right">';
        if (isset($results['MODERADOR_OBJ'])) {
            echo '<a href="' . $this->url(array('user' => $results['MODERADOR_OBJ']->url), 'users_user_view') . '" target="_BLANK">Ver Usuario</a>&nbsp;<b>[OK]</b>';
        } else {
            echo '' . $results['MODERADOR_MES'] . '&nbsp;<b>[FALLO]</b>';
        }

        echo '</tr><tr><td colspan="2"><b>Visibilidad: </b>' . $this->visibility(NULL, NULL, $results['VISIBILIDAD']) . '</td>';
        echo '</tr><tr><td colspan="2"><b>Descripción: </b>' . $results['DESCRIPCION'] . '</td></tr>';
    }
    echo '</table><hr />';
    echo '<a href="' . $this->url(array(), 'subjects_import') . '">Subir nuevamente</a> <input type="submit" value="Importar materias" /></form>';
}
