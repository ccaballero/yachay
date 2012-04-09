<h1><?php echo $this->PAGE->label ?></h1>
<?php if (!empty($this->gestion)) { ?><p><span class="mark">Gestion: </span><?php echo $this->gestion->label ?></p><?php } ?>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('subjects', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'subjects_list') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'subjects_new') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
<?php if ($this->acl('subjects', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
<?php if ($this->acl('subjects', 'import')) { ?><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array(), 'subjects_import') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'export')) { ?><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array(), 'subjects_export') ?>'" /><?php } ?>
    </div>

<?php if (count($this->subjects)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_subjects->_mapping['code'] ?></th>
            <th><?php echo $this->model_subjects->_mapping['label'] ?></th>
            <th><?php echo $this->model_subjects->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_subjects->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->subjects as $key => $subject) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td>
                <?php if ($this->acl('subjects', array('lock', 'delete'))) { ?><input type="checkbox" name="check[]" value="<?php echo $subject->ident ?>" /><?php } ?>
            </td>
            <td><?php echo $subject->code ?></td>
            <td><?php echo $subject->label ?></td>
            <td class="center">
            <?php if ($subject->status == 'active') { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Materia activa" title="Materia activa" />
            <?php } else { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Materia inactiva" title="Materia inactiva" />
            <?php } ?>
            </td>
            <td class="options">
            <?php if ($this->acl('subjects', 'view')) { ?>
                <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->acl('subjects', 'edit')) { ?>
                <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
            <?php if ($this->acl('subjects', 'lock')) { ?>
                <?php if ($subject->status == 'inactive') { ?>
                    <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Activar" title="Activar" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Desactivar" title="Desactivar" /></a>
                <?php } ?>
            <?php } ?>
            <?php if ($this->acl('subjects', 'delete') && $subject->isEmpty()) { ?>
                <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($subject->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen materias registradas en la gestión</p>
<?php } ?>

    <div>
<?php if ($this->acl('subjects', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'subjects_list') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'subjects_new') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
<?php if ($this->acl('subjects', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
<?php if ($this->acl('subjects', 'import')) { ?><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array(), 'subjects_import') ?>'" /><?php } ?>
<?php if ($this->acl('subjects', 'export')) { ?><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array(), 'subjects_export') ?>'" /><?php } ?>
    </div>
</form>
