<h1>Equipo: <?= $this->team->label ?>
<strong class="task">
<?php if ($this->team->status == 'active') { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Equipo activo" title="Equipo activo" />
<?php } else { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Equipo inactivo" title="Equipo inactivo" />
<?php } ?>
<?php if ($this->group->amTeacher() || $this->team->amMemberTeam()) { ?>
    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url), 'teams_team_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Grupo:</span> <?= $this->group->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->gestion->label ?>
</p>

<p><?= $this->team->description ?></p>

<h2>Miembros del equipo</h2>
<?php if (count($this->members)) { ?>
<div id="list">
    <?php foreach ($this->members as $member) { ?>
    <div class="box">
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $member->url), 'users_user_view') ?>">
        <?php } ?>
            <img src="<?= $this->media . 'users/thumbnail_small/' . $member->getAvatar() ?>" alt="<?= $member->getFullName() ?>" title="<?= $member->getFullName() ?>" />
        <?php if ($this->acl('users', 'view')) { ?>
            </a>
        <?php } ?>
        <?php if ($this->team->amMemberTeam()) { ?>
            <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url, 'user' => $member->url), 'teams_team_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<div class="clear"></div>
<?php } else { ?>
    <p>El equipo no se posee ningun miembro registrado.</p>
<?php } ?>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
