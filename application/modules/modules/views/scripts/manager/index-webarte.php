<h1><?php echo $this->page->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('modules', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'modules_list') ?>'" /><?php } ?>
<?php if ($this->acl('modules', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'modules_new') ?>'" /><?php } ?>
<?php if ($this->acl('modules', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
    </div>

<?php if (count($this->modules)) { ?>
    <table>
        <tr>
        <?php if ($this->acl('modules', 'lock')) { ?>
            <th>&nbsp;</th>
        <?php } ?>
            <th><?php echo $this->model_modules->_mapping['label'] ?></th>
            <th><?php echo $this->model_modules->_mapping['type'] ?></th>
            <th><?php echo $this->model_modules->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_modules->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->modules as $key => $module) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <?php if ($this->acl('modules', 'lock')) { ?>
            <td class="center"><input type="checkbox" name="check[]" value="<?php echo $module->ident ?>" /></td>
        <?php } ?>
            <td><?php echo $module->label ?></td>
            <td><?php echo $module->type ?></td>
            <td class="center">
            <?php if ($module->status == 'active') { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Modulo activo" title="Modulo activo" />
            <?php } else { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Modulo inactivo" title="Modulo inactivo" />
            <?php } ?>
            </td>
            <td class="options">
            <?php if ($this->acl('modules', 'view')) { ?>
                <a href="<?php echo $this->url(array('mod' => $module->url), 'modules_module_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->acl('modules', 'lock')) { ?>
                <?php if ($module->status == 'active') { ?>
                <a href="<?php echo $this->url(array('mod' => $module->url), 'modules_module_lock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock.png' ?>" alt="Bloquear" title="Bloquear" /></a>
                <?php } else { ?>
                <a href="<?php echo $this->url(array('mod' => $module->url), 'modules_module_unlock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock_open.png' ?>" alt="Desbloquear" title="Desbloquear" /></a>
                <?php } ?>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($module->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen modulos registrados</p>
<?php } ?>

    <div>
<?php if ($this->acl('modules', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'modules_list') ?>'" /><?php } ?>
<?php if ($this->acl('modules', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'modules_new') ?>'" /><?php } ?>
<?php if ($this->acl('modules', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
    </div>

</form>
