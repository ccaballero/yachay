<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if ($this->step == 1) {
    echo '<p>Para importar la asignación de usuarios se toman en cuenta las siguientes filas:</p>';
    echo '<ul>';
    echo '<li>Código o Usuario (Imprescindible)</li>';
    echo '<li>Cargo (Si no se especifica, se usa el cargo especificado mas abajo)</li>';
    echo '</ul>';

    echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
    echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
    echo '<table>';
    echo '<tr>';
    echo '<td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>';
    echo '<td>' . $this->formFile('file'). '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><b>Cargo:</b></td>';
    echo '<td>' . $this->assignement(NULL, NULL, NULL, 'type') . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><b>Incluir tambien en la materia:</b></td>';
    echo '<td><input type="checkbox" name="include" value="yes" checked="checked" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td colspan="2">(*) Campos obligatorios.</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>&nbsp;</td>';
    echo '<td>';
    echo '<input type="submit" value="Importar miembros" /> <a href="' . $this->lastPage() . '">Cancelar</a>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';
} else {
    echo '<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>';

    echo '<form method="post" action="" accept-charset="utf-8">';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" />';
    echo '<hr />';

    echo '<p>';
    echo '<b>Cargo: </b>' . $this->assignement(NULL, NULL, NULL, NULL, $this->type) . '<br />';
    echo ($this->include == 'yes') ? 'Incluyendo a los usuarios a la materia, en caso de no estar.' : '';
    echo '</p>';

    echo '<table width="100%">';
    foreach ($this->results as $results) {
        if ($results['ERROR']) {
            echo '<tr>';
            echo '<td rowspan="2" valign="top" width="18px">';
            echo '<input type="checkbox" disabled="disabled" />';
            echo '</td>';
            echo '<td><b>' . $results['USUARIO'] . '</b></td>';
            echo '<td align="right">El usuario no existe <b>[FALLO]</b></td>';
            echo '</tr>';
        } else {
            echo '<tr>';
            echo '<td rowspan="2" valign="top" width="18px">';
            echo '<input type="checkbox" name="users[]" ' . (!($results['ERROR'] || $results['ASSIGN_RES']) ? 'checked="checked"' : '') . ' value="' . $results['CODIGO']. '" />';
            echo '</td>';
            echo '<td><b>[' . $results['CODIGO'] . '] ' . $results['USUARIO_OBJ']->label . '</b></td>';
            echo '<td align="right"><a href="' . $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') . '" target="_BLANK">Ver Usuario</a> <b>[OK]</b></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td><b>Cargo: </b>' . $results['CARGO'] . '</td>';
            echo '<td align="right">';
            if (isset($results['TYPE'])) {
                echo '<b>[OK]</b>';
            } else {
                echo $results['CARGO_MES'] . ' <b>[FALLO]</b>';
            }
            echo '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';

    echo '<hr />';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" />';

    echo '</form>';
}
