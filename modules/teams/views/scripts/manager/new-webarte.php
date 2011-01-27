<h1><?= $this->PAGE->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?= $this->group->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="team_label">Nombre del equipo (*): </label><input id="team_label" name="label" type="text" value="<?= $this->team->label ?>" size="20" maxlength="20" /></p>
    <p><label for="team_description">Descripción: </label><textarea id="team_description" name="description" cols="50" rows="5"><?= $this->team->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear equipo" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
