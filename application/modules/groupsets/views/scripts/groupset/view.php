<?php

echo '<h1>Conjunto: ' . $this->groupset->label;
if ($this->groupset->author == $this->user->ident) {
    echo '[<i><a href="' . $this->url(array('groupset' => $this->groupset->ident), 'groupsets_groupset_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<h2>Grupos asignados</h2>';
if (count($this->subjects)) {
    foreach ($this->subjects as $subject) {
        $subject_label = '<b>' . $subject->label . '</b><br />';
        $group_label = '';
        foreach ($this->groups[$subject->ident] as $group) {
            foreach ($this->groupset_groups as $groupset_group) {
                if ($group->ident == $groupset_group->ident) {
                    $group_label .= '<a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a><br />';
                }
            }
        }
        if (!empty($group_label)) {
            echo $subject_label . $group_label;
        }
    }
} else {
    echo '<p>No existen asignaciones suyas en ninguna materia.</p>';
}
