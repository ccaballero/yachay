<h1>Asignacion de miembros a equipo</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <table>
        <tr>
            <td><input type="button" value="Administrador" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /></td>
            <td><input type="submit" value="Actualizar" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->members)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Equipo</th>
            </tr>
        <?php foreach ($this->members as $member) { ?>
            <tr>
                <td><?= $this->utf2html($member->label) ?></td>
                <td><?= $this->utf2html($member->getFullName()) ?></td>
                <td><center><?= $this->teams('team', 0, $this->group, $member->ident) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen usuarios sin asignaci&oacute;n de equipo.</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="button" value="Administrador" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /></td>
            <td><input type="submit" value="Actualizar" /></td>
        </tr>
    </table>
</form>
