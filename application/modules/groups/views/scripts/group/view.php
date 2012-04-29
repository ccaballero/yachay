<?php 

echo '<h1>Grupo: ' . $this->group->label;
if ($this->subject->amModerator()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_edit') . '">Editar</a></i>]';
}

echo '</h1>';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';
echo '<br />';
echo '<br />';
echo '<b>Dictada por: <i>' . $this->group->getTeacher()->getFullName() . '</i></b>';
echo '<br />';
echo '<b>Estado: <i>' . $this->status($this->group->status) . '</i></b>';
echo '<br />';
echo '<b>Metodo de evaluación: <i>' . $this->group->getEvaluation()->label . '</i></b>';
echo '<br />';

echo '<p>' . $this->group->description . '</p>';

if ($this->group->amTeacher() || $this->group->amMember()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign') . '">Ver miembros</a></i>]';
    echo '<br/>';
}
if ($this->group->amTeacher()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_manager') . '">Calificaciones</a></i>]';
} else if ($this->group->amMember()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_calification') . '">Calificaciones</a></i>]';
}

echo '<h2>Equipos registrados';
if ($this->group->amTeacher()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') . '">Administrar</a></i>]';
}
echo '</h2>';

if (count($this->teams)) {
    echo '<ul>';
    foreach ($this->teams as $team) {
        echo '<li>';
        if ($team->amMemberTeam()) {
            echo '<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') . '">Equipo ' . $team->label . '</a></i>';
        } else {
            echo '<i>Equipo ' . $team->label . '</i>';
        }
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>El grupo no posee ningun equipo registrado.</p>';
}

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, ));
