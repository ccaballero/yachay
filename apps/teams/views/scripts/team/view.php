<?php

echo '<h1>Equipo: ' . $this->team->label . ' ';
if ($this->team->amMemberTeam()) {
    echo '[<i><a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url), 'teams_team_edit') . '">Editar</a></i>]';
}
echo '</h1>';
echo '<i><b>Grupo: </b>' . $this->group->label . '</i>';
echo '<br />';
echo '<i><b>Materia: </b>' . $this->subject->label . '</i>';
echo '<br />';
echo '<b>Estado: <i>' . $this->status($this->team->status) . '</i></b>';
echo '<br />';

echo '<p>' . $this->team->description . '</p>';

echo '<h2>Miembros del equipo</h2>';
if (count($this->members)) {
    foreach ($this->members as $member) {
        echo '<table>';
        echo '<tr>';
        echo '<td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $member->url), 'users_user_view') . '">' . $member->label . '</a>';
        } else {
            echo $member->label;
        }
        echo '&nbsp;';
        if ($this->team->amMemberTeam()) {
            echo '[<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url, 'user' => $member->url), 'teams_team_member_delete') . '">Retirar</a>]';
        }
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo $member->getFullName();
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
} else {
    echo '<p>El equipo no se posee ningun miembro registrado.</p>';
}

echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'pager' => $this->pager, 'config' => $this->config, 'template' => $this->template));
