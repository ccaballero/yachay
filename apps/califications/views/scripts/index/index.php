<?php

echo '<h1>Calificaciones</h1>';
if (empty($this->user)) {
    if ($this->error == 'no user') {
        echo '<p>Ingrese su codigo SISS en el formulario</p>';
    } else if ($this->error == 'user invalid') {
        echo '<p>El codigo SISS que introdujo no es valido</p>';
    }
} else {
    if (!empty($this->gestion)) {
        echo '<i><b>Nombre Completo: </b>' . $this->user->getFullName() . '</i><br />';
        echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i><br />';
    }
    if (count($this->subjects)) {
        echo '<ul>';
        foreach ($this->subjects as $subject) {
            echo '<li>';
            if ($this->acl('subjects', 'view')) {
                echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_view') . '"><b>' . $subject->label . '</b></a>';
            } else {
                echo '<b>' . $subject->label . '</b>';
            }
            echo '&nbsp;';
            if ($this->acl('subjects', 'edit')) {
                echo '<b><i>[<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_edit') . '">Editar</a>]</i></b>';
            }
            echo '<br /><i>' . $subject->description . '</i>';
            echo '<ul>';
            foreach ($this->groups[$subject->ident] as $group) {
                echo '<li><a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a><br />';
                echo '<i><b>Metodo de Evaluación: </b>' . $this->evaluations[$group->ident]->label . '</i>';
                echo '<table width="100%"><tr>';
                foreach ($this->test_evaluations[$group->ident] as $test) {
                    echo '<th>' . $test->label . '</th>';
                }
                echo '</tr><tr>';
                foreach ($this->test_evaluations[$group->ident] as $test) {
                    echo '<td><center>';
                    if ($test->hasValues()) {
                        echo $this->testValues(NULL, $this->model->getCalification($group->ident, $this->user->ident, $this->evaluations[$group->ident]->ident, $test), $test, !empty($test->formula));
                    } else {
                        echo $this->califications[$group->ident][$test->ident];
                    }
                    echo '</center></td>';
                }
                echo '</tr></table></li>';
            }
            echo '</ul></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No existen asignaciones suyas en ninguna materia.</p>';
    }
}
