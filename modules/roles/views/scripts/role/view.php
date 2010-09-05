<h1>Rol: <?= $this->utf2html($this->role->label) ?>
    <?php if (Yeah_Acl::hasPermission('roles', 'edit')) { ?>
    [<i><a href="<?= $this->url(array('role' => $this->role->url), 'roles_role_edit') ?>">Editar</a></i>]
    <?php } ?>
</h1>
<p>
    <?= $this->utf2html($this->role->description) ?>
</p>

<h2>Usuarios asignados</h2>
<?php $users = Yeah_Adapter::getModel('users')->selectByRole($this->role->ident); ?>
<?php if (count($users)) { ?>
<center>
    <table width="100%">
        <tr>
            <th>Usuario</th>
            <th>Nombre completo</th>
            <th>Correo electronico</th>
        </tr>
        <?php foreach ($users as $user) { ?>
        <tr>
            <td><?= $this->utf2html($user->label) ?></td>
            <td><?= $this->utf2html($user->getFullName()) ?></td>
            <td><center><?= $this->utf2html($user->email) ?></center></td>
        </tr>
        <?php } ?>
    </table>
</center>
<?php } else { ?>
<p>No se registraron usuarios.</p>
<?php } ?>

<h2>Privilegios asignados</h2>
<?php $privileges = $this->role->findManyToManyRowset('modules_privileges_models_Privileges', 'modules_roles_models_Roles_Privileges') ?>
<?php if (count($privileges)) { ?>
<center>
    <table width="100%">
        <tr>
            <th>Modulo</th>
            <th>Privilegio</th>
            <th>Funcion</th>
        </tr>
        <?php foreach ($privileges as $privilege) { ?>
        <tr>
            <td><?= $privilege->module ?></td>
            <td><?= $this->utf2html($privilege->label) ?></td>
            <td><?= $privilege->privilege ?></td>
        </tr>
        <?php } ?>
    </table>
</center>
<?php } else { ?>
<p>No se registraron privilegios.</p>
<?php } ?>
