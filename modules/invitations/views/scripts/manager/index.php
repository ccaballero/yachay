<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'invitations_new') ?>'" /></div>

<?php if (count($this->invitations)) { ?>
    <table>
        <tr>
            <th><?= $this->model_invitations->_mapping['email'] ?></th>
            <th>Estado</th>
            <th>Opciones</th>
            <th><?= $this->model_invitations->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->invitations as $key => $invitation) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $invitation->email ?></td>
            <td class="center">
            <?php if ($invitation->accepted) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Invitación aceptada" title="Invitación aceptada" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/email.png' ?>" alt="Invitación pendiente" title="Invitación pendiente" />
            <?php } ?>
            </td>
            <td class="options">
                <?php if (!$invitation->accepted) { ?>
                    <a href="<?= $this->url(array('invitation' => $invitation->ident), 'invitations_invitation_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Revocar invitación" title="Revocar invitación" /></a>
                <?php } ?>
            </td>
            <td class="center"><?= $this->timestamp($invitation->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No enviaste ninguna invitación aún</p>
<?php } ?>

    <div><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'invitations_new') ?>'" /></div>
</form>
