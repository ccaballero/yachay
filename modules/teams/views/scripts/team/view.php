<h1>Equipo: <?= $this->utf2html($this->team->label) ?>
    <?php if ($this->team->amMemberTeam()) { ?>
        <i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url), 'teams_team_edit') ?>">[Editar]</a></i>
    <?php } ?>
</h1>
<i><b>Grupo: </b><?= $this->utf2html($this->group->label) ?></i>
<br />
<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>
<br />
<br />
<b>Estado: <i><?= $this->status($this->team->status) ?></i></b>
<br />

<p><?= $this->team->description ?></p>

<h2>Miembros del equipo</h2>
<?php if (count($this->members)) { ?>
    <?php foreach ($this->members as $member) { ?>
    <table>
        <tr>
            <td rowspan="2"><img src="<?= $this->media . '../users/thumbnail_small/' . $member->getAvatar() ?>" /></td>
            <td>
            <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $member->url), 'users_user_view') ?>"><?= $member->label ?></a>
            <?php } else { ?>
                <?= $member->label ?>
            <?php } ?>
            &nbsp;
            <?php if ($this->team->amMemberTeam()) { ?>
            	<a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $this->team->url, 'user' => $member->url), 'teams_team_member_delete') ?>">[Retirar]</a>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $member->getFullName() ?>
            </td>
        </tr>
    </table>
    <?php } ?>
<?php } else { ?>
    <p>El equipo no se posee ningun miembro registrado.</p>
<?php } ?>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
