<h1>Miembros: <?= $this->utf2html($this->community->label) ?></h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
        <?php if ($this->community->amModerator()) { ?>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
        <?php } ?>
        </tr>
    </table>
    <hr />

    <h2>Moderadores</h2>
<?php if (count($this->moderators) != 0) { ?>
    <?php foreach ($this->moderators as $moderator) { ?>
        <?php $assign = $this->community->getAssignement($moderator); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->community->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $moderator->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $moderator->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $moderator->url), 'users_user_view') ?>"><?= $moderator->label ?></a>
                <?php } else { ?>
                    <?= $moderator->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $moderator->getFullName() ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->community->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->community->amModerator() && $this->community->author <> $moderator->ident) { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No existe ningun moderador registrado en esta comunidad.</p>
<?php } ?>

    <h2>Miembros</h2>
<?php if (count($this->members) != 0) { ?>
    <?php foreach ($this->members as $member) { ?>
        <?php $assign = $this->community->getAssignement($member); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->community->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $member->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $member->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $member->url), 'users_user_view') ?>"><?= $member->label ?></a>
                <?php } else { ?>
                    <?= $member->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $member->getFullName() ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->community->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->community->amModerator() && $this->community->author <> $moderator->ident) { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No existe ningun miembro registrado en esta comunidad.</p>
<?php } ?>

    <hr />
    <table>
        <tr>
        <?php if ($this->community->amModerator()) { ?>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
