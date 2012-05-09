<?php

echo '<h1>' . $this->page->label . '</h1>';

if ($this->step == 1) {
    echo '<p>Para importar la asignación de usuarios se toman en cuenta las siguientes filas:</p>';
    echo '<ul><li>Código o Usuario (Imprescindible)</li><li>Cargo (Si no se especifica, se usa el cargo especificado mas abajo)</li></ul>';
    echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
    echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
    echo '<table><tr><td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>';
    echo '<td>' . $this->formFile('file') . '</td></tr>';
    echo '<tr><td><b>Cargo:</b></td><td>' . $this->assignement(NULL, 'type') . '</td></tr>';
    echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
    echo '<tr><td>&nbsp;</td><td><input type="submit" value="Importar miembros" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
    echo '</table></form>';
} else {
    echo '<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>';
    echo '<form method="post" action="" accept-charset="utf-8">';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" />';
    echo '<hr />';
    echo '<p><b>Cargo: </b>' . $this->assignement(NULL, NULL, $this->type) . '</p>';
    echo '<table width="100%">';

    foreach ($this->results as $results) {
        if ($results['ERROR']) {
            echo '<tr><td rowspan="2" valign="top" width="18px"><input type="checkbox" disabled="disabled" /></td>';
            echo '<td><b>' . $results['USUARIO'] . '</b></td><td align="right">El usuario no existe <b>[FALLO]</b></td></tr>';
        } else {
            echo '<tr><td rowspan="2" valign="top" width="18px">';
            echo '<input type="checkbox" name="users[]" ' . (!$results['ERROR'] ? 'checked="checked"' : '') . ' value="' . $results['CODIGO'] . '" /></td>';
            echo '<td><b>[' . $results['CODIGO'] . '] ' . $results['USUARIO_OBJ']->label . '</b></td>';
            echo '<td align="right"><a href="' . $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') . '" target="_BLANK">Ver Usuario</a> <b>[OK]</b></td></tr>';
            echo '<tr><td><b>Cargo: </b>' . $results['CARGO'] . '</td><td align="right">';
            if (isset($results['TYPE'])) {
                echo '<b>[OK]</b>';
            } else {
                echo $results['CARGO_MES'] . ' <b>[FALLO]</b>';
            }
            echo '</td></tr>';
        }
    }
    echo '</table>';
    echo '<hr />';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" />';
    echo '</form>';
}
