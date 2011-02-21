<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="career_label">Nombre de la carrera (*): </label><input id="career_label" name="label" type="text" value="<?= $this->career->label ?>" size="20" maxlength="64" /></p>
    <p><label for="career_description">Descripción: </label><textarea id="career_description" name="description" cols="50" rows="5"><?= $this->career->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear carrera" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
