<h1>Editar <?= ($this->note->priority) ? 'aviso' : 'nota' ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="note_message">Mensaje (*): </label><textarea id="note_message" name="message" cols="50" rows="5"><?= $this->note->note ?></textarea></p>
    <p><label for="note_tags">Etiquetas (**): </label><input name="tags" value="<?= $this->tags ?>" maxlength="128" /></p>
    <p><label for="note_priority">Convertir en Aviso </label><input type="checkbox" name="priority"/></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Guardar nota" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
