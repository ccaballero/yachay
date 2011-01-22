<h1>Editar criterio de evaluación</h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="evaluation_label">Nombre del criterio (*): </label><input type="text" name="label" size="15" maxlength="64" value="<?= $this->evaluation->label ?>" /></p>
    <p><label for="evaluation_access">Accesibilidad (*): </label><?= $this->accesibility('access', $this->evaluation->access) ?></p>
    <p><label for="evaluation_description">Descripción: </label><textarea id="evaluation_description" name="description" cols="50" rows="5"><?= $this->evaluation->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Editar criterio de evaluación" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
