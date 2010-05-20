<h1>Miembros: Grupo <?= $this->utf2html($this->group->label) ?></h1>
<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>

<form method="post" action="#">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
        <?php if ($this->group->amTeacher()) { ?>
            <td><input type="button" value="Agregar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') ?>'" /></td>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
            <td><input type="button" value="Importar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /></td>
            <td><input type="button" value="Exportar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') ?>'" /></td>
        <?php } ?>
        </tr>
    </table>
    <hr />

    <h2>Auxiliares</h2>
<?php if (count($this->auxiliars) != 0) { ?>
    <?php foreach ($this->auxiliars as $auxiliar) { ?>
        <?php $assign = $this->group->getAssignement($auxiliar); ?>
        <table width="100%">
            <tr>
                <td rowspan="2">
                <?php if ($this->group->amTeacher()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $auxiliar->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2"><img src="<?= $this->media . '../users/thumbnail_small/' . $auxiliar->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $auxiliar->url), 'users_user_view') ?>"><?= $auxiliar->label ?></a>
                <?php } else { ?>
                    <?= $auxiliar->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $auxiliar->getFullName() ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td>
                <?php if ($this->group->amTeacher()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td>
                <?php if ($this->group->amTeacher()) { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado auxiliares para este grupo.</p>
<?php } ?>
    <hr />
    <h2>Estudiantes</h2>
<?php if (count($this->students) != 0) { ?>
    <?php foreach ($this->students as $student) { ?>
        <?php $assign = $this->group->getAssignement($student); ?>
        <table width="100%">
            <tr>
                <td rowspan="2">
                <?php if ($this->group->amTeacher()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $student->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2"><img src="<?= $this->media . '../users/thumbnail_small/' . $student->getAvatar() ?>" /></td>
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
                <?php if ($this->group->amTeacher()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td>
                <?php if ($this->group->amTeacher()) { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado estudiantes para este grupo.</p>
<?php } ?>
    <hr />
    <h2>Invitados</h2>
<?php if (count($this->guests) != 0) { ?>
    <?php foreach ($this->guests as $guest) { ?>
        <?php $assign = $this->group->getAssignement($guest); ?>
        <table width="100%">
            <tr>
                <td rowspan="2">
                <?php if ($this->group->amTeacher()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $guest->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2"><img src="<?= $this->media . '../users/thumbnail_small/' . $guest->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $guest->url), 'users_user_view') ?>"><?= $guest->label ?></a>
                <?php } else { ?>
                    <?= $guest->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $guest->getFullName() ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td>
                <?php if ($this->group->amTeacher()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td>
                <?php if ($this->group->amTeacher()) { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_unlock') ?>">[Habilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_lock') ?>">[Deshabilitar]</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_delete') ?>">[Retirar]</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado visitantes para este grupo.</p>
<?php } ?>

    <hr />
    <table>
        <tr>
        <?php if ($this->group->amTeacher()) { ?>
            <td><input type="button" value="Agregar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') ?>'" /></td>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
            <td><input type="button" value="Importar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /></td>
            <td><input type="button" value="Exportar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') ?>'" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
