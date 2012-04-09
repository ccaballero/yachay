<h1><?php echo $this->role->label ?>
<strong class="task">
<?php if ($this->acl('roles', 'edit')) { ?>
    <a href="<?php echo $this->url(array('role' => $this->role->url), 'roles_role_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p><?php echo $this->role->description ?></p>

<h2>Usuarios asignados</h2>
<?php if (count($this->users)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_users->_mapping['label'] ?></th>
            <th><?php echo $this->model_users->_mapping['formalname'] ?></th>
            <th><?php echo $this->model_users->_mapping['email'] ?></th>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $user->label ?></td>
            <td><?php echo $user->getFullName() ?></td>
            <td><?php echo $user->email ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No se registraron usuarios.</p>
<?php } ?>

<h2>Privilegios asignados</h2>
<?php if (count($this->privileges)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_privileges->_mapping['label'] ?></th>
            <th><?php echo $this->model_privileges->_mapping['module'] ?></th>
            <th><?php echo $this->model_privileges->_mapping['privilege'] ?></th>
        </tr>
    <?php foreach ($this->privileges as $key => $privilege) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $privilege->label ?></td>
            <td><?php echo $privilege->module ?></td>
            <td><?php echo $privilege->privilege ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No se registraron privilegios.</p>
<?php } ?>
