<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="team_label">Nombre del equipo (*): </label><input id="team_label" name="label" type="text" value="<?= $this->team->label ?>" size="20" maxlength="20" /></p>
    <p><label for="team_description">Descripción: </label><textarea id="team_description" name="description" cols="50" rows="5"><?= $this->team->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear equipo" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
