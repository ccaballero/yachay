<h1>Añadir miembros: Grupo <?= $this->group->label ?></h1>
<p>
    <span class="mark">Materia: </span><?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <div>
<input type="submit" value="Agregar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
    </div>

<?php if (count($this->users)) { ?>
    <table>
        <tr>
            <th><?= $this->model_users->_mapping['code'] ?></th>
            <th><?= $this->model_users->_mapping['label'] ?></th>
            <th>Nombre Completo</th>
            <th><?= $this->model_users->_mapping['role'] ?></th>
            <th>Cargo</th>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $user->code ?></td>
            <td><?= $user->label ?></td>
            <td><?= $user->getFullName() ?></td>
            <td><?= $user->getRole()->label ?></td>
            <td class="center"><?= $this->assignement($user, $this->subject, $this->group, 'users') ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen usuarios disponibles</p>
<?php } ?>

    <div>
<input type="submit" value="Agregar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
    </div>
</form>
