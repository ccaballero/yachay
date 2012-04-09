<h1><?php echo $this->PAGE->label ?></h1>
<?php if (!empty($this->gestion)) { ?><p><span class="mark">Gestion: </span><?php echo $this->gestion->label ?></p><?php } ?>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="subject_label">Nombre de materia (*): </label><input id="subject_label" name="label" type="text" value="<?php echo $this->subject->label ?>" maxlength="64" /></p>
    <p><label for="subject_moderator">Moderador (*): </label><?php echo $this->moderator('subject_moderator', 'moderator', $this->subject->moderator) ?></p>
    <p><label for="subject_code">Codigo (*): </label><input id="subject_code" name="code" type="text" value="<?php echo $this->subject->code ?>" maxlength="7" /></p>
    <p><label for="subject_visibility">Visibilidad (*): </label><?php echo $this->visibility('subject_visibility', 'visibility', $this->subject->visibility) ?></p>
    <p><label for="subject_description">Descripción: </label><textarea id="subject_description" name="description" cols="50" rows="5"><?php echo $this->subject->description ?></textarea></p>
    <p><label>Areas a las que pertenece:</label>&nbsp;</p>
<?php foreach ($this->areas as $area) { ?>
    <p>
        <label>&nbsp;</label>
        <input type="checkbox" <?php echo in_array($area->ident, $this->checks_areas) ? 'checked="checked" ' : '' ?>name="areas[]" value="<?php echo $area->ident ?>" />
        <span class="form"><?php echo $area->label ?></span>
    </p>
<?php } ?>
    <p><label>Carreras a las que pertenece:</label>&nbsp;</p>
<?php foreach ($this->careers as $career) { ?>
    <p>
        <label>&nbsp;</label>
        <input type="checkbox" <?php echo in_array($career->ident, $this->checks_careers) ? 'checked="checked" ' : '' ?>name="careers[]" value="<?php echo $career->ident ?>" />
        <span class="form"><?php echo $career->label ?></span>
    </p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear materia" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
