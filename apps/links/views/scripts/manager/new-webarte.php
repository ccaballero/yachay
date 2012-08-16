<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="link_publish">Publicar en (*): </label><?php echo $this->context('publish') ?></p>
    <p><label for="link_link">Enlace (*): </label><input name="link" value="<?php echo $this->link->link ?>" maxlength="128" /></p>
    <p><label for="link_message">Descripción: </label><textarea id="link_message" name="description" cols="50" rows="5"><?php echo $this->link->description ?></textarea></p>
    <p><label for="link_tags">Etiquetas (**): </label><input name="tags" value="<?php echo $this->tags ?>" maxlength="128" /></p>
    <p><label for="link_priority">Convertir en Aviso </label><input type="checkbox" name="priority"/></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Crear enlace" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
