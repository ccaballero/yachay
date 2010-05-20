<h1>Administrador de roles</h1>

<table>
    <tr>
        <?php if (Yeah_Acl::hasPermission('roles', 'list')) { ?>
        <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'roles_list') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('roles', 'new')) { ?>
        <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'roles_new') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('roles', 'assign')) { ?>
        <td><input type="button" value="Asignaci&oacute;n" onclick="location.href='<?= $this->url(array(), 'roles_assign') ?>'" /></td>
        <?php } ?>
    </tr>
</table>

<hr />
<?php if (count($this->roles)) { ?>
<center>
    <table width="100%">
        <tr>
            <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
            <th>Opciones</th>
            <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            
        </tr>
    <?php foreach ($this->roles as $role) { ?>
        <tr>
            <td><?= $this->utf2html($role->label) ?></td>
            <td>
                <center>
                    <?php if (Yeah_Acl::hasPermission('roles', 'view')) { ?>
                    <a href="<?= $this->url(array('role' => $role->url), 'roles_role_view') ?>">Ver</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('roles', 'edit')) { ?>
                    <a href="<?= $this->url(array('role' => $role->url), 'roles_role_edit') ?>">Editar</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('roles', 'delete')) { ?>
                    <?php if ($role->isEmpty()) { ?>
                    <a href="<?= $this->url(array('role' => $role->url), 'roles_role_delete') ?>">Eliminar</a>
                    <?php } ?>
                    <?php } ?>
                </center>
            </td>
            <td><center><?= $this->timestamp($role->tsregister) ?></center></td>
        </tr>
        <?php } ?>
    </table>
</center>
<?php } else { ?>
    <p>No existen roles registrados</p>
<?php } ?>
<hr />

<table>
    <tr>
        <?php if (Yeah_Acl::hasPermission('roles', 'list')) { ?>
        <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'roles_list') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('roles', 'new')) { ?>
        <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'roles_new') ?>'" /></td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('roles', 'assign')) { ?>
        <td><input type="button" value="Asignaci&oacute;n" onclick="location.href='<?= $this->url(array(), 'roles_assign') ?>'" /></td>
        <?php } ?>
    </tr>
</table>
