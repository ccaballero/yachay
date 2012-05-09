<h1><?php echo $this->page->label ?></h1>

    <div>
<?php if ($this->acl('roles', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'roles_list') ?>'" /><?php } ?>
<?php if ($this->acl('roles', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'roles_new') ?>'" /><?php } ?>
<?php if ($this->acl('roles', 'assign')) { ?><input type="button" name="assign" value="Asignación" onclick="location.href='<?php echo $this->url(array(), 'roles_assign') ?>'" /><?php } ?>
    </div>

<?php if (count($this->roles)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_roles->_mapping['label'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_roles->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->roles as $key => $role) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $role->label ?></td>
            <td class="options">
            <?php if ($this->acl('roles', 'view')) { ?>
                <a href="<?php echo $this->url(array('role' => $role->url), 'roles_role_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
            <?php } ?>
            <?php if ($this->acl('roles', 'edit')) { ?>
                <a href="<?php echo $this->url(array('role' => $role->url), 'roles_role_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
            <?php if ($this->acl('roles', 'delete') && $role->isEmpty()) { ?>
                <a href="<?php echo $this->url(array('role' => $role->url), 'roles_role_delete') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($role->tsregister) ?></td>
        </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen roles registrados</p>
<?php } ?>

    <div>
<?php if ($this->acl('roles', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'roles_list') ?>'" /><?php } ?>
<?php if ($this->acl('roles', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'roles_new') ?>'" /><?php } ?>
<?php if ($this->acl('roles', 'assign')) { ?><input type="button" name="assign" value="Asignación" onclick="location.href='<?php echo $this->url(array(), 'roles_assign') ?>'" /><?php } ?>
    </div>
