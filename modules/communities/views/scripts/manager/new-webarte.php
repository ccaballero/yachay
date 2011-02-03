<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="community_label">Nombre de comunidad (*): </label><input id="community_label" name="label" type="text" value="<?= $this->community->label ?>" size="20" maxlength="64" /></p>
    <p><label for="community_mode">Modalidad (*): </label><?= $this->mode('mode', $this->community->mode) ?></p>
    <p><label for="community_photo">Avatar: </label><?= $this->formFile('file') ?></p>
    <p><label for="community_tags">Etiquetas (**): </label><input id="community_tags" name="tags" type="text" value="<?= $this->tags ?>" size="20" maxlength="128" /></p>
    <p><label for="community_description">Descripción: </label><textarea id="community_description" name="description" cols="50" rows="5"><?= $this->community->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Crear comunidad" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
