<h1>Peticiones: <?= $this->community->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
        <?php if ($this->community->amModerator()) { ?>
            <td><input type="submit" value="Aceptar Petición" name="accept" /></td>
            <td><input type="submit" value="Denegar Petición" name="decline" /></td>
        <?php } ?>
        </tr>
    </table>
    <hr />

<?php if (count($this->applicants) != 0) { ?>
    <?php foreach ($this->applicants as $applicant) { ?>
        <?php $assign = $this->community->getPetition($applicant); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->community->amModerator()) { ?>
                    <input type="checkbox" name="applicants[]" value="<?= $applicant->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td>
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $applicant->url), 'users_user_view') ?>"><?= $applicant->label ?></a>
                <?php } else { ?>
                    <?= $applicant->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $applicant->getFullName() ?></td>
            </tr>
            <tr>
                <td>Fecha de solicitud: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="240px">
                <?php if ($this->community->amModerator()) { ?>
                    [<a href="<?= $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_accept') ?>">Aceptar</a>]
                    [<a href="<?= $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_decline') ?>">Denegar</a>]
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No existe ninguna petición de ingreso en esta comunidad.</p>
<?php } ?>

    <hr />
    <table>
        <tr>
        <?php if ($this->community->amModerator()) { ?>
            <td><input type="submit" value="Aceptar Petición" name="accept" /></td>
            <td><input type="submit" value="Denegar Petición" name="decline" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
