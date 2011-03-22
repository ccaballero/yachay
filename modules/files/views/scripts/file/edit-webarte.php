<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="file_description">Descripción (*): </label><textarea id="file_description" name="description" cols="50" rows="5"><?= $this->file->description ?></textarea></p>
    <p><label for="file_tags">Etiquetas (**): </label><input name="tags" value="<?= $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Guardar archivo" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
