<h1>Grupo <?php echo $this->group->label ?>
<strong class="task">
<?php if ($this->group->status == 'active') { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Grupo activo" />
<?php } else { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Grupo inactivo" />
<?php } ?>
<?php if ($this->group->amTeacher() || $this->group->amMember()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign') ?>"><img src="<?php echo $this->template->htmlbase . 'images/group.png' ?>" alt="Ver miembros" title="Ver miembros" /></a>
<?php } ?>
<?php if ($this->group->amTeacher()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_manager') ?>"><img src="<?php echo $this->template->htmlbase . 'images/coins.png' ?>" alt="Calificaciones" title="Calificaciones" /></a>
<?php } else if ($this->group->amMember()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_calification') ?>"><img src="<?php echo $this->template->htmlbase . 'images/coins.png' ?>" alt="Calificaciones" title="Calificaciones" /></a>
<?php } ?>
<?php if ($this->subject->amModerator()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<p><?php echo $this->group->description ?></p>

<h2>Equipos registrados
<strong class="task">
<?php if ($this->group->amTeacher()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>"><img src="<?php echo $this->template->htmlbase . 'images/key.png' ?>" alt="Administrador de grupos" title="Administrador de grupos" /></a>
<?php } ?>
</strong>
</h2>

<?php if (count($this->teams)) { ?>
<ul>
    <?php foreach ($this->teams as $team) { ?>
    <li>
        <?php if ($team->amMemberTeam()) { ?>
            <i><a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>">Equipo <?php echo $team->label ?></a></i>
        <?php } else { ?>
            <i>Equipo <?php echo $team->label ?></i>
        <?php } ?>
    </li>
    <?php } ?>
</ul>
<?php } else { ?>
    <p>El grupo no posee ningun equipo registrado.</p>
<?php } ?>

<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'pager' => $this->pager, 'config' => $this->config, 'template' => $this->template, 'paginator' => true,)) ?>
