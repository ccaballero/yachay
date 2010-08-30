<h1>Administrador de usuarios</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('users', 'list')) { ?>
            <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'users_list') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'new')) { ?>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'users_new') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'lock')) { ?>
            <td><input type="submit" name="lock" value="Bloquear" /></td>
            <td><input type="submit" name="unlock" value="Desbloquear" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'delete')) { ?>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'import')) { ?>
            <td><input type="button" value="Importar" onclick="location.href='<?= $this->url(array(), 'users_import') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'export')) { ?>
            <td><input type="button" value="Exportar" onclick="location.href='<?= $this->url(array(), 'users_export') ?>'" /></td>
        <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->users)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th>Nombre Completo</th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->users as $user) { ?>
            <tr>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', array('lock', 'delete'))) { ?>
                    <input type="checkbox" name="check[]" value="<?= $user->ident ?>" />
                <?php } ?>
                </td>
                <td><?= $this->utf2html($user->label) ?></td>
                <td><?= $this->utf2html($user->getFullName()) ?></td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>">Ver</a>
                <?php } ?>
                <?php if (Yeah_Acl::hasPermission('users', 'edit')) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>">Editar</a>
                <?php } ?>
                <?php if (Yeah_Acl::hasPermission('users', 'lock')) { ?>
                <?php
                    // FIXME Cambiar de lugar tanta logica interna
                    global $USER;
                    $model = Yeah_Adapter::getModel('roles');
                    $roles = $model->selectByIncludes($USER->role);
                    $valid_role = false;
                    foreach ($roles as $role) {
                        if ($role->ident == $user->role) {
                            $valid_role |= true;
                        }
                    }
                    if ($valid_role) { ?>
                    <?php if ($user->status == 'active') { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_lock') ?>">Bloquear</a>
                    <?php } else { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_unlock') ?>">Desbloquear</a>
                    <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if (Yeah_Acl::hasPermission('users', 'delete')) { ?>
                <?php
                    // FIXME Cambiar de lugar tanta logica interna
                    global $USER;
                    $model = Yeah_Adapter::getModel('roles');
                    $roles = $model->selectByIncludes($USER->role);
                    $valid_role = false;
                    foreach ($roles as $role) {
                        if ($role->ident == $user->role) {
                            $valid_role |= true;
                        }
                    }
                    if ($valid_role) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_delete') ?>">Eliminar</a>
                    <?php } ?>
                <?php } ?>
                </td>
                <td><center><?= $this->timestamp($user->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen usuarios registrados</p>
<?php } ?>
    <hr />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('users', 'list')) { ?>
            <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'users_list') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'new')) { ?>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'users_new') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'lock')) { ?>
            <td><input type="submit" name="lock" value="Bloquear" /></td>
            <td><input type="submit" name="unlock" value="Desbloquear" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'delete')) { ?>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'import')) { ?>
            <td><input type="button" value="Importar" onclick="location.href='<?= $this->url(array(), 'users_import') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('users', 'export')) { ?>
            <td><input type="button" value="Exportar" onclick="location.href='<?= $this->url(array(), 'users_export') ?>'" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
