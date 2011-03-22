<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="video_proportion">Proporción (*): </label><?= $this->proportion('video_proportion', 'proportion', $this->video->proportion) ?></p>
    <p><label for="video_description">Descripción (*): </label><textarea id="video_description" name="description" cols="50" rows="5"><?= $this->video->description ?></textarea></p>
    <p><label for="video_tags">Etiquetas (**): </label><input name="tags" value="<?= $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Guardar video" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
