<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="file_publish">Publicar en (*): </label><?php echo $this->context('publish') ?></p>
    <p><label for="file_file">Archivo (2 MiB max.) (*): </label><?php echo $this->formFile('file') ?></p>
    <p><label for="file_message">Descripción: </label><textarea id="file_message" name="description" cols="50" rows="5"><?php echo $this->file->description ?></textarea></p>
    <p><label for="file_tags">Etiquetas (**): </label><input name="tags" value="<?php echo $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Subir archivo" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
