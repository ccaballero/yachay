<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="entry_description">Descripción (*): </label><textarea id="entry_description" name="description" cols="50" rows="5"><?php echo $this->entry->description ?></textarea></p>
    <p><label for="entry_tags">Etiquetas (**): </label><input name="tags" value="<?php echo $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Crear sugerencia" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
