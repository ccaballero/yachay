<h1>Miembros: <?= $this->utf2html($this->community->label) ?></h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
        <?php if ($this->community->amAuthor()) { ?>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
        <?php } ?>
        </tr>
    </table>
    <hr />

<?php if (count($this->students) != 0) { ?>
    <?php foreach ($this->students as $student) { ?>
        <?php $assign = $this->subject->getAssignement($student); ?>
        <table width="100%">
            <tr>
                <td rowspan="2">
                <?php if ($this->subject->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $student->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $student->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $student->url), 'users_user_view') ?>"><?= $student->label ?></a>
                <?php } else { ?>
                    <?= $student->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $student->getFullName() ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td>
                <?php if ($this->subject->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td>
                <?php if ($this->subject->amModerator()) { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se ha unido ninguna persona a esta comunidad.</p>
<?php } ?>

    <hr />
    <table>
        <tr>
        <?php if ($this->community->amAuthor()) { ?>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
