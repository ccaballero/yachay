<h1><?php echo $this->PAGE->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?php echo $this->group->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <div>
<input type="button" name="manager" value="Administrador" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /><input type="submit" name="update" value="Actualizar" />
    </div>

<?php if (count($this->members)) { ?>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Nombre Completo</th>
            <th>Equipo</th>
        </tr>
    <?php foreach ($this->members as $key => $member) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $member->label ?></td>
            <td><?php echo $member->getFullName() ?></td>
            <td class="center"><?php echo $this->teams('team', 0, $this->group, $member->ident) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen usuarios sin asignación de equipo.</p>
<?php } ?>

    <div>
<input type="button" name="manager" value="Administrador" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_manager') ?>'" /><input type="submit" name="update" value="Actualizar" />
    </div>
</form>
