<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="video_publish">Publicar en (*): </label><?php echo $this->context('publish') ?></p>
    <p><label for="video_file">Archivo (.flv) (20 MiB max.) (*): </label><?php echo $this->formFile('video') ?></p>
    <p><label for="video_proportion">Proporción (*): </label><?php echo $this->proportion('video_proportion', 'proportion', $this->video->proportion) ?></p>
    <p><label for="video_message">Descripción: </label><textarea id="video_message" name="description" cols="50" rows="5"><?php echo $this->video->description ?></textarea></p>
    <p><label for="video_tags">Etiquetas (**): </label><input name="tags" value="<?php echo $this->tags ?>" maxlength="128" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Subir video" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
