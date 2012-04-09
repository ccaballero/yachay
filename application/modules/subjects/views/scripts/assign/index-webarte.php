<h1>Miembros: <?php echo $this->subject->label ?></h1>
<p><span class="mark">Gestion: </span><?php echo $this->subject->getGestion()->label ?></p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->subject->amModerator()) { ?><input type="button" name="new" value="Agregar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') ?>'" /><input type="submit" name="unlock" value="Habilitar" /><input type="submit" name="lock" value="Deshabilitar" /><input type="submit" name="delete" value="Retirar" /><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') ?>'" /><?php } ?>
    </div>

<div id="block">
    <h2>Docentes</h2>
<?php if (count($this->teachers) != 0) { ?>
    <?php foreach ($this->teachers as $teacher) { ?>
        <?php $assign = $this->subject->getAssignement($teacher); ?>
        <div class="member">
            <?php if ($this->subject->amModerator()) { ?>
                <input type="checkbox" name="members[]" value="<?php echo $teacher->ident ?>" />
            <?php } ?>
                <p><span class="title"><?php echo $teacher->getFullName() ?></span></p>
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?php echo $this->url(array('user' => $teacher->url), 'users_user_view') ?>"><img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $teacher->getAvatar() ?>" alt="<?php echo $teacher->getFullName() ?>" title="<?php echo $teacher->getFullName() ?>" /></a>
            <?php } else { ?>
                <img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $teacher->getAvatar() ?>" alt="<?php echo $teacher->getFullName() ?>" title="<?php echo $teacher->getFullName() ?>" />
            <?php } ?>
                <div class="body">
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $teacher->url), 'subjects_subject_assign_member_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?php echo $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado docentes para esta materia.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Auxiliares</h2>
<?php if (count($this->auxiliars) != 0) { ?>
    <?php foreach ($this->auxiliars as $auxiliar) { ?>
        <?php $assign = $this->subject->getAssignement($auxiliar); ?>
        <div class="member">
        <?php if ($this->subject->amModerator()) { ?>
            <input type="checkbox" name="members[]" value="<?php echo $auxiliar->ident ?>" />
        <?php } ?>
            <p><span class="title"><?php echo $auxiliar->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $auxiliar->url), 'users_user_view') ?>"><img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $auxiliar->getAvatar() ?>" alt="<?php echo $auxiliar->getFullName() ?>" title="<?php echo $auxiliar->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $auxiliar->getAvatar() ?>" alt="<?php echo $auxiliar->getFullName() ?>" title="<?php echo $auxiliar->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $auxiliar->url), 'subjects_subject_assign_member_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?php echo $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado auxiliares para esta materia.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Estudiantes</h2>
<?php if (count($this->students) != 0) { ?>
    <?php foreach ($this->students as $student) { ?>
        <?php $assign = $this->subject->getAssignement($student); ?>
        <div class="member">
        <?php if ($this->subject->amModerator()) { ?>
            <input type="checkbox" name="members[]" value="<?php echo $student->ident ?>" />
        <?php } ?>
            <p><span class="title"><?php echo $student->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $student->url), 'users_user_view') ?>"><img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $student->getAvatar() ?>" alt="<?php echo $student->getFullName() ?>" title="<?php echo $student->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $student->getAvatar() ?>" alt="<?php echo $student->getFullName() ?>" title="<?php echo $student->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $student->url), 'subjects_subject_assign_member_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?php echo $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado estudiantes para esta materia.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Invitados</h2>
<?php if (count($this->guests) != 0) { ?>
    <?php foreach ($this->guests as $guest) { ?>
        <?php $assign = $this->subject->getAssignement($guest); ?>
        <div class="member">
        <?php if ($this->subject->amModerator()) { ?>
            <input type="checkbox" name="members[]" value="<?php echo $guest->ident ?>" />
        <?php } ?>
            <p><span class="title"><?php echo $guest->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $guest->url), 'users_user_view') ?>"><img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $guest->getAvatar() ?>" alt="<?php echo $guest->getFullName() ?>" title="<?php echo $guest->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $guest->getAvatar() ?>" alt="<?php echo $guest->getFullName() ?>" title="<?php echo $guest->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
                <?php } else { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
                <?php } ?>
            <?php } ?>
            <?php if ($this->subject->amModerator()) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'user' => $guest->url), 'subjects_subject_assign_member_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?php echo $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se han registrado visitantes para esta materia.</p>
<?php } ?>
    <div class="clear"></div>
</div>

    <div>
<?php if ($this->subject->amModerator()) { ?><input type="button" name="new" value="Agregar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_new') ?>'" /><input type="submit" name="unlock" value="Habilitar" /><input type="submit" name="lock" value="Deshabilitar" /><input type="submit" name="delete" value="Retirar" /><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_export') ?>'" /><?php } ?>
    </div>
</form>
