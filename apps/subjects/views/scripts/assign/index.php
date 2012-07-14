<?php

echo '<h1>Miembros: ' . $this->subject->label . '</h1>';
echo '<i><b>Gestion: </b>' . $this->subject->getGestion()->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->subject->amModerator()) {
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') . '">Agregar</a>]</td>';
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td><td><input type="submit" value="Deshabilitar" name="lock" /></td><td><input type="submit" value="Retirar" name="delete" /></td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') . '">Importar</a>]</td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') . '">Exportar</a>]</td>';
}
echo '</tr></table><hr />';

echo '<h2>Docentes</h2>';
if (count($this->teachers) != 0) {
    echo '<table width="100%">';

    foreach ($this->teachers as $teacher) {
        $assign = $this->subject->getAssignement($teacher);
        echo '<tr><td rowspan="2" width="18px">';
        if ($this->subject->amModerator()) {
            echo '<input type="checkbox" name="members[]" value="' . $teacher->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $teacher->url), 'users_user_view') . '">' . $teacher->label . '</a>';
        } else {
            echo $teacher->label;
        }
        echo '</td><td colspan="2">' . $teacher->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->subject->amModerator()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td><td width="40%">';
        if ($this->subject->amModerator()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se han registrado docentes para esta materia.</p>';
}
echo '<hr />';

echo '<h2>Auxiliares</h2>';
if (count($this->auxiliars) != 0) {
    echo '<table width="100%">';
    foreach ($this->auxiliars as $auxiliar) {
        $assign = $this->subject->getAssignement($auxiliar);
        echo '<tr><td rowspan="2" width="18px">';
        if ($this->subject->amModerator()) {
            echo '<input type="checkbox" name="members[]" value="' . $auxiliar->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $auxiliar->url), 'users_user_view') . '">' . $auxiliar->label . '</a>';
        } else {
            echo $auxiliar->label;
        }
        echo '</td><td colspan="2">' . $auxiliar->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->subject->amModerator()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td><td width="40%">';
        if ($this->subject->amModerator()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se han registrado auxiliares para esta materia.</p>';
}
echo '<hr />';

echo '<h2>Estudiantes</h2>';
if (count($this->students) != 0) {
    echo '<table width="100%">';
    foreach ($this->students as $student) {
        $assign = $this->subject->getAssignement($student);
        echo '<tr><td rowspan="2" width="18px">';
        if ($this->subject->amModerator()) {
            echo '<input type="checkbox" name="members[]" value="' . $student->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $student->url), 'users_user_view') . '">' . $student->label . '</a>';
        } else {
            echo $student->label;
        }
        echo '</td><td colspan="2">' . $student->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->subject->amModerator()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td><td width="40%">';
        if ($this->subject->amModerator()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se han registrado estudiantes para esta materia.</p>';
}
echo '<hr />';

echo '<h2>Invitados</h2>';
if (count($this->guests) != 0) {
    echo '<table width="100%">';
    foreach ($this->guests as $guest) {
        $assign = $this->subject->getAssignement($guest);
        echo '<tr><td rowspan="2" width="18px">';
        if ($this->subject->amModerator()) {
            echo '<input type="checkbox" name="members[]" value="' . $guest->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $guest->url), 'users_user_view') . '">' . $guest->label . '</a>';
        } else {
            echo $guest->label;
        }
        echo '</td><td colspan="2">' . $guest->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->subject->amModerator()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td><td width="40%">';
        if ($this->subject->amModerator()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No se han registrado visitantes para esta materia.</p>';
}

echo '<table><tr>';
if ($this->subject->amModerator()) {
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') . '">Agregar</a>]</td>';
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td><td><input type="submit" value="Deshabilitar" name="lock" /></td><td><input type="submit" value="Retirar" name="delete" /></td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') . '">Importar</a>]</td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') . '">Exportar</a>]</td>';
}
echo '</tr></table>';
echo '<hr />';

echo '</form>';
