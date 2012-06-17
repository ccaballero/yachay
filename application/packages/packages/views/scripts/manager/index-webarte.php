<h1><?php echo $this->page->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('packages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'packages_list') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'packages_new') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
    </div>

<?php if (count($this->packages)) { ?>
    <table>
        <tr>
        <?php if ($this->acl('packages', 'lock')) { ?>
            <th>&nbsp;</th>
        <?php } ?>
            <th>Etiqueta</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Opciones</th>
            <th>Fecha de Registro</th>
        </tr>
    <?php foreach ($this->packages as $key => $package) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <?php if ($this->acl('packages', 'lock')) { ?>
            <td class="center"><input type="checkbox" name="check[]" value="<?php echo $package->ident ?>" /></td>
        <?php } ?>
            <td><?php echo $package->label ?></td>
            <td><?php echo $package->type ?></td>
            <td class="center">
            <?php if ($package->status == 'active') { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Modulo activo" title="Modulo activo" />
            <?php } else { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Modulo inactivo" title="Modulo inactivo" />
            <?php } ?>
            </td>
            <td class="options">
            <?php if ($this->acl('packages', 'view')) { ?>
                <a href="<?php echo $this->url(array('mod' => $package->url), 'packages_package_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->acl('packages', 'lock')) { ?>
                <?php if ($package->status == 'active') { ?>
                <a href="<?php echo $this->url(array('mod' => $package->url), 'packages_package_lock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock.png' ?>" alt="Bloquear" title="Bloquear" /></a>
                <?php } else { ?>
                <a href="<?php echo $this->url(array('mod' => $package->url), 'packages_package_unlock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock_open.png' ?>" alt="Desbloquear" title="Desbloquear" /></a>
                <?php } ?>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($package->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen modulos registrados</p>
<?php } ?>

    <div>
<?php if ($this->acl('packages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'packages_list') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'packages_new') ?>'" /><?php } ?>
<?php if ($this->acl('packages', 'lock')) { ?><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><?php } ?>
    </div>

</form>
