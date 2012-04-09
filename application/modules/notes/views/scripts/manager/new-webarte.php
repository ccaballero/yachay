<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="note_publish">Publicar en (*): </label><?php echo $this->context('publish') ?></p>
    <p><label for="note_message">Mensaje (*): </label><textarea id="note_message" name="message" cols="50" rows="5"><?php echo $this->note->note ?></textarea></p>
    <p><label for="note_tags">Etiquetas (**): </label><input name="tags" value="<?php echo $this->tags ?>" maxlength="128" /></p>
    <p><label for="note_priority">Convertir en Aviso </label><input type="checkbox" name="priority"/></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Crear nota" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
