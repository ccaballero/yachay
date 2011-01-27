<h1>Grupo <?= $this->group->label ?>
<strong class="task">
<?php if ($this->group->status == 'active') { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Grupo activo" />
<?php } else { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Grupo inactivo" />
<?php } ?>
<?php if ($this->group->amTeacher() || $this->group->amMember()) { ?>
    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/group.png' ?>" alt="Ver miembros" title="Ver miembros" /></a>
<?php } ?>
<?php if ($this->group->amTeacher()) { ?>
    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_manager') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/coins.png' ?>" alt="Calificaciones" title="Calificaciones" /></a>
<?php } ?>
<?php if ($this->subject->amModerator()) { ?>
    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?= $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->subject->getGestion()->label ?>
</p>

<p><?= $this->group->description ?></p>

<h2>Equipos registrados
<strong class="task">
<?php if ($this->group->amTeacher()) { ?>
    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Administrador de grupos" title="Administrador de grupos" /></a>
<?php } ?>
</strong>
</h2>

<?php if (count($this->teams)) { ?>
<ul>
    <?php foreach ($this->teams as $team) { ?>
    <li>
        <?php if ($team->amMemberTeam()) { ?>
            <i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>">Equipo <?= $team->label ?></a></i>
        <?php } else { ?>
            <i>Equipo <?= $team->label ?></i>
        <?php } ?>
    </li>
    <?php } ?>
</ul>
<?php } else { ?>
    <p>El grupo no posee ningun equipo registrado.</p>
<?php } ?>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
