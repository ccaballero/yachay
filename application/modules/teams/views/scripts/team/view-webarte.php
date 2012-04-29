<h1>Equipo: <?php echo $this->team->label ?>
<strong class="task">
<?php if ($this->team->status == 'active') { ?>
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Equipo activo" title="Equipo activo" />
<?php } else { ?>
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Equipo inactivo" title="Equipo inactivo" />
<?php } ?>
<?php if ($this->group->amTeacher() || $this->team->amMemberTeam()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url), 'teams_team_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?php echo $this->group->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->gestion->label ?>
</p>

<p><?php echo $this->team->description ?></p>

<h2>Miembros del equipo</h2>
<?php if (count($this->members)) { ?>
<div id="list">
    <?php foreach ($this->members as $member) { ?>
    <div class="box">
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $member->url), 'users_user_view') ?>">
        <?php } ?>
            <img src="<?php echo $this->media . 'users/thumbnail_small/' . $member->getAvatar() ?>" alt="<?php echo $member->getFullName() ?>" title="<?php echo $member->getFullName() ?>" />
        <?php if ($this->acl('users', 'view')) { ?>
            </a>
        <?php } ?>
        <?php if ($this->team->amMemberTeam()) { ?>
            <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url, 'user' => $member->url), 'teams_team_member_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<div class="clear"></div>
<?php } else { ?>
    <p>El equipo no se posee ningun miembro registrado.</p>
<?php } ?>

<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => true,)) ?>
