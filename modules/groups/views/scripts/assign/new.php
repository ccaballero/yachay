<h1>A&ntilde;adir miembros: Grupo <?= $this->utf2html($this->group->label) ?></h1>
<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>

<form method="post" action="">
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
                <th><?= $this->utf2html($this->model->_mapping['code']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th>Nombre Completo</th>
                <th><?= $this->utf2html($this->model->_mapping['role']) ?></th>
                <th>Cargo</th>
            </tr>
        <?php foreach ($this->users as $user) { ?>
            <tr>
                <td><?= $user->code ?></td>
                <td><?= $this->utf2html($user->label) ?></td>
                <td><?= $this->utf2html($user->getFullName()) ?></td>
                <td><?= $this->utf2html($user->getRole()->label) ?></td>
                <td><center><?= $this->assignement($user, $this->subject, $this->group, 'users') ?></center></td>
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
