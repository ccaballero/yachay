<h1>Añadir miembros: Grupo <?php echo $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <div>
<input type="submit" value="Agregar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" />
    </div>

<?php if (count($this->users)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_users->_mapping['code'] ?></th>
            <th><?php echo $this->model_users->_mapping['label'] ?></th>
            <th>Nombre Completo</th>
            <th><?php echo $this->model_users->_mapping['role'] ?></th>
            <th>Cargo</th>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $user->code ?></td>
            <td><?php echo $user->label ?></td>
            <td><?php echo $user->getFullName() ?></td>
            <td><?php echo $user->getRole()->label ?></td>
            <td class="center"><?php echo $this->assignement($user, $this->subject, $this->group, 'users') ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen usuarios disponibles</p>
<?php } ?>

    <div>
<input type="submit" value="Agregar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" />
    </div>
</form>
