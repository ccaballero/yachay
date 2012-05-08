<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if (!empty($this->gestion)) {
    echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i>';
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
        echo '<br />';
        echo '<i>' . $subject->description . '</i>';
        echo '<ul>';
        foreach ($this->groups[$subject->ident] as $group) {
            echo '<li>';
            echo '<a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a>';
            $assign = $this->model_groups_users->findByGroupAndUser($group->ident, $this->user->ident);
            if (!empty($assign)) {
                echo '[' . $this->typeAssign($assign->type) . ']';
            } else {
                echo '[' . $this->typeAssign('teacher') . ']';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen asignaciones suyas en ninguna materia.</p>';
}
