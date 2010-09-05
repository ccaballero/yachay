<h1>Lista de roles</h1>

<?php if (count($this->roles)) { ?>
    <ul>
    <?php foreach ($this->roles as $role) { ?>
        <li>
            <?php if (Yeah_Acl::hasPermission('roles', 'view')) { ?>
            <a href="<?= $this->url(array('role' => $role->url), 'roles_role_view') ?>">
                <b><?= $this->utf2html($role->label) ?></b>
            </a>
            <?php } else { ?>
                <b><?= $this->utf2html($role->label) ?></b>
            <?php } ?>
            &nbsp;
            <?php if (Yeah_Acl::hasPermission('roles', 'edit')) { ?>
                <b><i>[<a href="<?= $this->url(array('role' => $role->url), 'roles_role_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
            <br />
            <i><?= $this->utf2html($role->description) ?></i>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen roles registrados</p>
<?php } ?>
