<h1><?= $this->role->label ?>
<strong class="task">
<?php if ($this->acl('roles', 'edit')) { ?>
    <a href="<?= $this->url(array('role' => $this->role->url), 'roles_role_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p><?= $this->role->description ?></p>

<h2>Usuarios asignados</h2>
<?php if (count($this->users)) { ?>
    <table>
        <tr>
            <th><?= $this->model_users->_mapping['label'] ?></th>
            <th><?= $this->model_users->_mapping['formalname'] ?></th>
            <th><?= $this->model_users->_mapping['email'] ?></th>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $user->label ?></td>
            <td><?= $user->getFullName() ?></td>
            <td><?= $user->email ?></td>
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
            <th><?= $this->model_privileges->_mapping['label'] ?></th>
            <th><?= $this->model_privileges->_mapping['module'] ?></th>
            <th><?= $this->model_privileges->_mapping['privilege'] ?></th>
        </tr>
    <?php foreach ($this->privileges as $key => $privilege) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $privilege->label ?></td>
            <td><?= $privilege->module ?></td>
            <td><?= $privilege->privilege ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No se registraron privilegios.</p>
<?php } ?>
