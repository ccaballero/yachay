<h1><?php echo $this->page->label ?></h1>
<?php if (count($this->roles)) { ?>
    <dl>
    <?php foreach ($this->roles as $role) { ?>
        <dt>
            <?php if ($this->acl('roles', 'view')) { ?>
                <a href="<?php echo $this->url(array('role' => $role->url), 'roles_role_view') ?>"><?php echo $role->label ?></a>
            <?php } else { ?>
                <?php echo $role->label ?>
            <?php } ?>
            <?php if ($this->acl('roles', 'edit')) { ?>
                <a href="<?php echo $this->url(array('role' => $role->url), 'roles_role_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?php echo $role->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen roles registrados</p>
<?php } ?>
