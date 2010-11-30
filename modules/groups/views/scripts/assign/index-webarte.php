<h1>Miembros: Grupo <?= $this->group->label ?></h1>

<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?= $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div><?php if ($this->group->amTeacher()) { ?>
<input type="button" name="new" value="Agregar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') ?>'" /><input type="submit" name="unlock" value="Habilitar" /><input type="submit" name="lock" value="Deshabilitar" /><input type="submit" name="delete" value="Retirar" /><input type="button" name="import" value="Importar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') ?>'" />
    <?php } ?></div>

<div id="block">
    <h2>Auxiliares</h2>
<?php if (count($this->auxiliars) != 0) { ?>
    <?php foreach ($this->auxiliars as $auxiliar) { ?>
        <?php $assign = $this->group->getAssignement($auxiliar); ?>
        <div class="member">
        <?php if ($this->group->amTeacher()) { ?>
            <input type="checkbox" name="members[]" value="<?= $auxiliar->ident ?>" />
        <?php } ?>
            <p><span class="title"><?= $auxiliar->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $auxiliar->url), 'users_user_view') ?>"><img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $auxiliar->getAvatar() ?>" alt="<?= $auxiliar->getFullName() ?>" title="<?= $auxiliar->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $auxiliar->getAvatar() ?>" alt="<?= $auxiliar->getFullName() ?>" title="<?= $auxiliar->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $auxiliar->url), 'groups_group_assign_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?= $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado auxiliares para este grupo.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Estudiantes</h2>
<?php if (count($this->students) != 0) { ?>
    <?php foreach ($this->students as $student) { ?>
        <?php $assign = $this->group->getAssignement($student); ?>
        <div class="member">
        <?php if ($this->group->amTeacher()) { ?>
            <input type="checkbox" name="members[]" value="<?= $student->ident ?>" />
        <?php } ?>
            <p><span class="title"><?= $student->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $student->url), 'users_user_view') ?>"><img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $student->getAvatar() ?>" alt="<?= $student->getFullName() ?>" title="<?= $student->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $student->getAvatar() ?>" alt="<?= $student->getFullName() ?>" title="<?= $student->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $student->url), 'groups_group_assign_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?= $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado estudiantes para este grupo.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Invitados</h2>
<?php if (count($this->guests) != 0) { ?>
    <?php foreach ($this->guests as $guest) { ?>
        <?php $assign = $this->group->getAssignement($guest); ?>
        <div class="member">
        <?php if ($this->group->amTeacher()) { ?>
            <input type="checkbox" name="members[]" value="<?= $guest->ident ?>" />
        <?php } ?>
            <p><span class="title"><?= $guest->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $guest->url), 'users_user_view') ?>"><img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $guest->getAvatar() ?>" alt="<?= $guest->getFullName() ?>" title="<?= $guest->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $guest->getAvatar() ?>" alt="<?= $guest->getFullName() ?>" title="<?= $guest->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->group->amTeacher()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'user' => $guest->url), 'groups_group_assign_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?= $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado visitantes para este grupo.</p>
<?php } ?>
    <div class="clear"></div>
</div>

    <div><?php if ($this->group->amTeacher()) { ?>
<input type="button" name="new" value="Agregar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_new') ?>'" /><input type="submit" name="unlock" value="Habilitar" /><input type="submit" name="lock" value="Deshabilitar" /><input type="submit" name="delete" value="Retirar" /><input type="button" name="import" value="Importar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_export') ?>'" />
    <?php } ?></div>
</form>
