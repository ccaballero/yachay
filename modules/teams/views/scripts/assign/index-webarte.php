<h1><?= $this->PAGE->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?= $this->group->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <div>
<input type="button" name="manager" value="Administrador" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /><input type="submit" name="update" value="Actualizar" />
    </div>

<?php if (count($this->members)) { ?>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Nombre Completo</th>
            <th>Equipo</th>
        </tr>
    <?php foreach ($this->members as $key => $member) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $member->label ?></td>
            <td><?= $member->getFullName() ?></td>
            <td class="center"><?= $this->teams('team', 0, $this->group, $member->ident) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen usuarios sin asignación de equipo.</p>
<?php } ?>

    <div>
<input type="button" name="manager" value="Administrador" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /><input type="submit" name="update" value="Actualizar" />
    </div>
</form>
