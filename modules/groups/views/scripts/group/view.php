<h1>Grupo: <?= $this->utf2html($this->group->label) ?>
    <?php if ($this->subject->amModerator()) { ?>
        [<i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_edit') ?>">Editar</a></i>]
    <?php } ?>
</h1>
<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>
<br />
<br />
<b>Dictada por: <i><?= $this->group->getTeacher()->getFullName() ?></i></b>
<br />
<b>Estado: <i><?= $this->status($this->group->status) ?></i></b>
<br />
<b>Metodo de evaluaci&oacute;n: <i><?= $this->utf2html($this->group->getEvaluation()->label) ?></i></b>
<br />

<p><?= $this->group->description ?></p>

<?php if ($this->group->amTeacher() || $this->group->amMember()) { ?>
[<i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign') ?>">Ver miembros</a></i>]
<br/>
<?php } ?>
<?php if ($this->group->amTeacher()) { ?>
	[<i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_manager') ?>">Calificaciones</a></i>]
<?php } ?>

<h2>Equipos registrados
<?php if ($this->group->amTeacher()) { ?>
    [<i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>">Administrar</a></i>]
<?php } ?>
</h2>
<?php if (count($this->teams)) { ?>
<ul>
    <?php foreach ($this->teams as $team) { ?>
    <li>
        <?php if ($team->amMemberTeam()) { ?>
            <i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>">Equipo <?= $this->utf2html($team->label) ?></a></i>
        <?php } else { ?>
            <i>Equipo <?= $this->utf2html($team->label) ?></i>
        <?php } ?>
    </li>
    <?php } ?>
</ul>
<?php } else { ?>
    <p>El grupo no posee ningun equipo registrado.</p>
<?php } ?>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
