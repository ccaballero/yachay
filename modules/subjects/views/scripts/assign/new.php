<h1>Añadir miembros: <?= $this->subject->label ?></h1>
<i><b>Gestion: </b><?= $this->gestion->label ?></i>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
    <table>
        <tr>
            <td><input type="submit" value="Agregar usuarios" /></td>
            <td><a href="<?= $this->lastPage() ?>">Cancelar</a></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->users)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th><?= $this->model_users->_mapping['code'] ?></th>
                <th><?= $this->model_users->_mapping['label'] ?></th>
                <th>Nombre Completo</th>
                <th><?= $this->model_users->_mapping['role'] ?></th>
                <th>Cargo</th>
            </tr>
        <?php foreach ($this->users as $user) { ?>
            <tr>
                <td><?= $user->code ?></td>
                <td><?= $user->label ?></td>
                <td><?= $user->getFullName() ?></td>
                <td><?= $user->getRole()->label ?></td>
                <td><center><?= $this->assignement($user, 'users') ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen usuarios disponibles</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="submit" value="Agregar usuarios" /></td>
            <td><a href="<?= $this->lastPage() ?>">Cancelar</a></td>
        </tr>
    </table>
</form>
