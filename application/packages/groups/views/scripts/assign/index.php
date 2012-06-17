<?php

echo '<h1>Miembros: Grupo ' . $this->group->label . '</h1>';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr>';
if ($this->group->amTeacher()) {
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') . '">Agregar</a>]</td>';
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td>';
    echo '<td><input type="submit" value="Deshabilitar" name="lock" /></td>';
    echo '<td><input type="submit" value="Retirar" name="delete" /></td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') . '">Importar</a>]</td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') . '">Exportar</a>]</td>';
}
echo '</tr>';
echo '</table>';
echo '<hr />';

echo '<h2>Auxiliares</h2>';
if (count($this->auxiliars) != 0) {
    foreach ($this->auxiliars as $auxiliar) {
        $assign = $this->group->getAssignement($auxiliar);
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td rowspan="2" width="18px">';
        if ($this->group->amTeacher()) {
            echo '<input type="checkbox" name="members[]" value="' . $auxiliar->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $auxiliar->url), 'users_user_view') . '">' . $auxiliar->label . '</a>';
        } else {
            echo $auxiliar->label;
        }
        echo '</td>';
        echo '<td colspan="2">' . $auxiliar->getFullName() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->group->amTeacher()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td width="350px">';
        if ($this->group->amTeacher()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
} else {
    echo '<p>No se han registrado auxiliares para este grupo.</p>';
}
echo '<hr />';
echo '<h2>Estudiantes</h2>';
if (count($this->students) != 0) {
    foreach ($this->students as $student) {
        $assign = $this->group->getAssignement($student);
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td rowspan="2" width="18px">';
        if ($this->group->amTeacher()) {
            echo '<input type="checkbox" name="members[]" value="' . $student->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $student->url), 'users_user_view') . '">' . $student->label . '</a>';
        } else {
            echo $student->label;
        }
        echo '</td>';
        echo '<td colspan="2">' . $student->getFullName() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->group->amTeacher()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td width="350px">';
        if ($this->group->amTeacher()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
} else {
    echo '<p>No se han registrado estudiantes para este grupo.</p>';
}
echo '<hr />';
echo '<h2>Invitados</h2>';
if (count($this->guests) != 0) {
    foreach ($this->guests as $guest) {
        $assign = $this->group->getAssignement($guest);
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td rowspan="2" width="18px">';
        if ($this->group->amTeacher()) {
            echo '<input type="checkbox" name="members[]" value="' . $guest->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $guest->url), 'users_user_view') . '">' . $guest->label . '</a>';
        } else {
            echo $guest->label;
        }
        echo '</td>';
        echo '<td colspan="2">' . $guest->getFullName() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="80px">';
        if ($this->group->amTeacher()) {
            echo $this->enable($assign->status);
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td width="350px">';
        if ($this->group->amTeacher()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
} else {
    echo '<p>No se han registrado visitantes para este grupo.</p>';
}

echo '<hr />';
echo '<table>';
echo '<tr>';
if ($this->group->amTeacher()) {
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') . '">Agregar</a>]</td>';
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td>';
    echo '<td><input type="submit" value="Deshabilitar" name="lock" /></td>';
    echo '<td><input type="submit" value="Retirar" name="delete" /></td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') . '">Importar</a>]</td>';
    echo '<td>[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') . '">Exportar</a>]</td>';
}
echo '</tr>';
echo '</table>';
echo '</form>';
