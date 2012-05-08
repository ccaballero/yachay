<?php

echo '<h1>Materia: ' . $this->subject->label;
if (!$this->historial && $this->acl('subjects', 'edit')) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url), 'subjects_subject_edit') . '">Editar</a></i>]';
}
echo '</h1>';

echo '<b>Moderada por: <i>' .  $this->subject->getModerator()->getFullName() . '</i></b><br />';
echo '<b>Estado: <i>' .  $this->status($this->subject->status) . '</i></b><br />';
echo '<b>Visibilidad: <i>' .  $this->visibility(null, null, $this->subject->visibility) . '</i></b><br />';
echo '<p>' .  $this->subject->description . '</p>';

if ((!$this->historial) && ($this->subject->amModerator() || $this->subject->amMember())) {
    echo '[<i><a href="' .  $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign') . '">Ver miembros</a></i>]';
}

echo '<h2>Areas involucradas';
if (!$this->historial && $this->acl('areas', array('new', 'delete'))) {
    echo '[<i><a href="' .  $this->url(array(), 'areas_manager') . '">Administrar</a></i>]';
}
echo '</h2>';

if (count($this->areas)) {
    echo '<ul>';
    foreach ($this->areas as $area) {
        echo '<li><i><a href="' .  $this->url(array('area' => $area->url), 'areas_area_view') . '">' .  $area->label . '</a></i></li>';
    }
    echo '</ul>';
} else {
    echo '<p>La materia no se encuentra registrada en ningun area.</p>';
}

if (!$this->historial) {
    echo '<h2>Grupos registrados';
    if ($this->subject->amModerator()) {
        echo '[<i><a href="' .  $this->url(array('subject' => $this->subject->url), 'groups_manager') . '">Administrar</a></i>]';
    }
    echo '</h2>';

    if (count($this->groups)) {
        echo '<ul>';
        foreach ($this->groups as $group) {
            echo '<li><i><a href="' .  $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' .  $group->label . '</a> [' .  $group->getTeacher()->getFullName() . ']</i>';
            $assign = $this->model_groups_users->findByGroupAndUser($group->ident, $this->user->ident);
            if (!empty($assign)) {
                echo '[' . $this->typeAssign($assign->type) . ']';
            }
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>La materia no se posee ningun grupo registrado.</p>';
    }
}

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE));
