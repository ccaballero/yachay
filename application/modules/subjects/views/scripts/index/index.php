<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

if (!empty($this->gestion)) {
    echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i>';
}
if (count($this->subjects) > 0) {
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
        if (!empty($this->assign[$subject->url])) {
            echo '[' . $this->typeAssign($this->assign[$subject->url]) . ']';
        }
        echo '<br />';
        echo '<i>' . $subject->description . '</i>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No existen materias registradas en la gestion.</p>';
}
