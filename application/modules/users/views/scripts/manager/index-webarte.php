<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('users', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'users_list') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'users_new') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'lock')) { ?><input type="submit" name="lock" value="Bloquear" /><input type="submit" name="unlock" value="Desbloquear" /><?php } ?>
<?php if ($this->acl('users', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
<?php if ($this->acl('users', 'import')) { ?><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array(), 'users_import') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'export')) { ?><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array(), 'users_export') ?>'" /><?php } ?>
    </div>

<?php if (count($this->users)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model->_mapping['label'] ?></th>
            <th><?php echo $this->model->_mapping['formalname'] ?></th>
            <th><?php echo $this->model->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php if ($this->acl('users', array('lock', 'delete'))) { ?><input type="checkbox" name="check[]" value="<?php echo $user->ident ?>" /><?php } ?></td>
            <td><?php echo $user->label ?></td>
            <td><?php echo $user->getFullName() ?></td>
            <td class="center">
            <?php if ($user->status == 'active') { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario activo" />
            <?php } else { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario inactivo" />
            <?php } ?>
            </td>
            <td class="options">
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_view') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->user->hasFewerPrivileges($user)) { ?>
                <?php if ($this->acl('users', 'edit')) { ?>
                    <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <?php } ?>
                <?php if ($this->acl('users', 'lock')) { ?>
                    <?php if ($user->status == 'active') { ?>
                        <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_lock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Bloquear" title="Bloquear" /></a>
                    <?php } else { ?>
                        <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_unlock') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Desbloquear" title="Desbloquear" /></a>
                    <?php } ?>
                <?php } ?>
                <?php if ($this->acl('users', 'delete')) { ?>
                    <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                <?php } ?>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($user->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen usuarios registrados</p>
<?php } ?>

    <div>
<?php if ($this->acl('users', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'users_list') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'users_new') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'lock')) { ?><input type="submit" name="lock" value="Bloquear" /><input type="submit" name="unlock" value="Desbloquear" /><?php } ?>
<?php if ($this->acl('users', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
<?php if ($this->acl('users', 'import')) { ?><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array(), 'users_import') ?>'" /><?php } ?>
<?php if ($this->acl('users', 'export')) { ?><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array(), 'users_export') ?>'" /><?php } ?>
    </div>
</form>
