<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="subject_label">Nombre de materia (*): </label><input id="subject_label" name="label" type="text" value="<?= $this->subject->label ?>" maxlength="64" /></p>
    <p><label for="subject_moderator">Moderador (*): </label><?= $this->moderator('subject_moderator', 'moderator', $this->subject->moderator) ?></p>
    <p><label for="subject_code">Codigo (*): </label><input id="subject_code" name="code" type="text" value="<?= $this->subject->code ?>" maxlength="7" /></p>
    <p><label for="subject_visibility">Visibilidad (*): </label><?= $this->visibility('subject_visibility', 'visibility', $this->subject->visibility) ?></p>
    <p><label for="subject_description">Descripción: </label><textarea id="subject_description" name="description" cols="50" rows="5"><?= $this->subject->description ?></textarea></p>
    <p><label>Areas a las que pertenece:</label>&nbsp;</p>
<?php foreach ($this->areas as $area) { ?>
    <p>
        <label>&nbsp;</label>
        <input type="checkbox" <?= in_array($area->ident, $this->checks) ? 'checked="checked" ' : '' ?>name="areas[]" value="<?= $area->ident ?>" />
        <span class="form"><?= $area->label ?></span>
    </p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Actualizar materia" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
