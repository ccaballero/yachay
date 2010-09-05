<h1>Miembros: <?= $this->utf2html($this->subject->label) ?></h1>
<i><b>Gestion: </b><?= $this->utf2html($this->subject->getGestion()->label) ?></i>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
        <?php if ($this->subject->amModerator()) { ?>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') ?>">Agregar</a>]</td>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>">Importar</a>]</td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') ?>">Exportar</a>]</td>
        <?php } ?>
        </tr>
    </table>
    <hr />

    <h2>Docentes</h2>
<?php if (count($this->teachers) != 0) { ?>
    <?php foreach ($this->teachers as $teacher) { ?>
        <?php $assign = $this->subject->getAssignement($teacher); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->subject->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $teacher->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $teacher->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $teacher->url), 'users_user_view') ?>"><?= $teacher->label ?></a>
                <?php } else { ?>
                    <?= $teacher->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $this->utf2html($teacher->getFullName()) ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->subject->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->subject->amModerator()) { ?>
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_unlock') ?>">Habilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_lock') ?>">Deshabilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_delete') ?>">Retirar</a>]
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado docentes para esta materia.</p>
<?php } ?>
    <hr />
    <h2>Auxiliares</h2>
<?php if (count($this->auxiliars) != 0) { ?>
    <?php foreach ($this->auxiliars as $auxiliar) { ?>
        <?php $assign = $this->subject->getAssignement($auxiliar); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->subject->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $auxiliar->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $auxiliar->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $auxiliar->url), 'users_user_view') ?>"><?= $auxiliar->label ?></a>
                <?php } else { ?>
                    <?= $auxiliar->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $this->utf2html($auxiliar->getFullName()) ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->subject->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->subject->amModerator()) { ?>
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_unlock') ?>">Habilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_lock') ?>">Deshabilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_delete') ?>">Retirar</a>]
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado auxiliares para esta materia.</p>
<?php } ?>
    <hr />
    <h2>Estudiantes</h2>
<?php if (count($this->students) != 0) { ?>
    <?php foreach ($this->students as $student) { ?>
        <?php $assign = $this->subject->getAssignement($student); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
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
                <td colspan="2"><?= $this->utf2html($student->getFullName()) ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->subject->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->subject->amModerator()) { ?>
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_unlock') ?>">Habilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_lock') ?>">Deshabilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_delete') ?>">Retirar</a>]
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado estudiantes para esta materia.</p>
<?php } ?>
    <hr />
    <h2>Invitados</h2>
<?php if (count($this->guests) != 0) { ?>
    <?php foreach ($this->guests as $guest) { ?>
        <?php $assign = $this->subject->getAssignement($guest); ?>
        <table width="100%">
            <tr>
                <td rowspan="2" width="18px">
                <?php if ($this->subject->amModerator()) { ?>
                    <input type="checkbox" name="members[]" value="<?= $guest->ident ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td rowspan="2" width="50px"><img src="<?= $this->media . '../users/thumbnail_small/' . $guest->getAvatar() ?>" /></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $guest->url), 'users_user_view') ?>"><?= $guest->label ?></a>
                <?php } else { ?>
                    <?= $guest->label ?>
                <?php } ?>
                </td>
                <td colspan="2"><?= $this->utf2html($guest->getFullName()) ?></td>
            </tr>
            <tr>
                <td>Miembro desde: <?= $this->timestamp($assign->tsregister) ?></td>
                <td width="80px">
                <?php if ($this->subject->amModerator()) { ?>
                    <?= $this->enable($assign->status) ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
                <td width="240px">
                <?php if ($this->subject->amModerator()) { ?>
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_unlock') ?>">Habilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_lock') ?>">Deshabilitar</a>]
                    [<a href="<?= $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_delete') ?>">Retirar</a>]
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado visitantes para esta materia.</p>
<?php } ?>

    <hr />
    <table>
        <tr>
        <?php if ($this->subject->amModerator()) { ?>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') ?>">Agregar</a>]</td>
            <td><input type="submit" value="Habilitar" name="unlock" /></td>
            <td><input type="submit" value="Deshabilitar" name="lock" /></td>
            <td><input type="submit" value="Retirar" name="delete" /></td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>">Importar</a>]</td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') ?>">Exportar</a>]</td>
        <?php } ?>
        </tr>
    </table>
</form>
