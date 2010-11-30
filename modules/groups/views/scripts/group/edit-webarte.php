 <h1>Editar grupo</h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="group_label">Nombre/Número de grupo (*): </label><input id="group_label" name="label" type="text" value="<?= $this->group->label ?>" size="20" maxlength="20" /></p>
    <p><label for="group_teacher">Docente (*): </label><?= $this->teacher('teacher', $this->group->teacher, $this->subject) ?></p>
    <p><label for="group_evaluation">Método de evaluación (*): </label><?= $this->evaluation('evaluation', $this->group->evaluation) ?></p>
    <p><label for="group_description">Descripción: </label><textarea id="group_description" name="description" cols="50" rows="5"><?= $this->group->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Editar grupo" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
