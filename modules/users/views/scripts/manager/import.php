<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if ($this->step == 1) {
    echo '<p>Para importar usuarios se toman en cuenta las siguientes filas:</p>';
    echo '<ul><li>Código (Imprescindible)</li><li>Nombre Completo (Imprescindible, útil para exportación de datos)</li>';
    echo '<li>Correo electrónico</li><li>Rol (Si no se especifica, se usa el rol especificado mas abajo)</li>';
    echo '<li>Usuario (Si no se especifica, se usa el código)</li><li>Apellidos</li><li>Nombres</li><li>Carrera</li></ul>';

    echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
    echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
    echo '<table><tr><td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>';
    echo '<td>' . $this->formFile('file') . '</td></tr>';

    $first = true;
    foreach ($this->options as $key => $option) {
        echo '<tr><td>' . $option . '</td>';
        echo '<td><input type="radio"' . ($first ? ' checked="checked" ' : ' ') . 'name="type" value="' . $key . '" /></td></tr>';
        $first = false;
    }

    echo '<tr><td><b>Rol:</b></td>';
    echo '<td>' . $this->role('role') . '</td></tr>';
    echo '<tr><td><b>Generador de contraseña:</b></td>';
    echo '<td>' . $this->password('password') . '</td>';
    echo '</tr><tr><td colspan="2">(*) Campos obligatorios.</td></tr><tr><td>&nbsp;</td><td><input type="submit" value="Importar usuarios" /> ';
    echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
    echo '</td></tr></table></form>';

} else {
    echo '<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>';
    echo '<form method="post" action="" accept-charset="utf-8">';
    echo '<a href="' . $this->url(array(), 'users_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" /><hr />';
    echo '<p><b>Modalidad: </b>' . $this->options[$this->type] . '<br />';
    echo '<b>Generador de contraseña: </b>' . $this->password(NULL, $this->password);
    echo '</p><table width="100%">';

    foreach ($this->results as $results) {
        echo '<tr><td rowspan="5" valign="top" width="18px">';
        echo '<input type="checkbox" name="users[]"' . ($results['CHECKED'] && (isset($results['ROL_OBJ'])) ? ' checked="checked" ' : ' ') . 'value="' . $results['CODIGO'] . '" />';
        echo '</td><td colspan="2"><b>[' . $results['CODIGO'] . '] ' . $results['NOMBRE COMPLETO'] . '</b></td>';
        echo '<td align="right">';

        if ($results['CODIGO_NUE']) {
            echo '[NUEVO]&nbsp;';
            if ($this->acl('users', 'new')) {
                echo '<b>[OK]</b>';
            } else {
                echo 'No tienes permiso para crear usuarios.&bnsp;<b>FALLO</b>';
            }
        } else {
            echo '<a href="' . $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') . '" target="_BLANK">Ver Usuario</a>';
            echo '&nbsp;[EDICION]&nbsp;';
            if ($this->acl('users', 'edit')) {
                echo '<b>[OK]</b>';
            } else {
                echo 'No tienes permiso para editar usuarios.&nbsp;<b>FALLO</b>';
            }
        }

        echo '</td></tr><tr>';
        echo '<td colspan="2"><b>Rol: </b>' . $results['ROL'] . '</td>';
        echo '<td align="right">';

        if (isset($results['ROL_OBJ'])) {
            echo '<a href="' . $this->url(array('role' => $results['ROL_OBJ']->url), 'roles_role_view') . '" target="_BLANK">Ver Rol</a>&nbsp;<b>[OK]</b>';
        } else {
            echo '<b>[FALLO]</b>';
        }

        echo '</tr><tr><td width="30%">';
        echo '<b>Usuario: </b>' . $results['USUARIO'] . '</td><td>';
        echo '<b>Correo electrónico: </b>' . $this->none($results['CORREO ELECTRONICO']) . '</td><td>&nbsp;</td></tr><tr><td width="30%">';
        echo '<b>Apellidos: </b>' . $this->none($results['APELLIDOS']) . '</td><td>';
        echo '<b>Nombres: </b>' . $this->none($results['NOMBRES']) . '</td><td>&nbsp;</td></tr><tr>';
        echo '<td colspan="3"><b>Carrera: </b>' . $this->none($results['CARRERA']) . '</td></tr>';
    }

    echo '</table><hr />';
    echo '<a href="' . $this->url(array(), 'users_import') . '">Subir nuevamente</a> ';
    echo '<input type="submit" value="Importar usuarios" /></form>';
}
