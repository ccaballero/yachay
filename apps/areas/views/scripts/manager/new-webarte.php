<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="area_label">Nombre de area (*): </label><input id="area_label" name="label" type="text" value="<?php echo $this->area->label ?>" size="20" maxlength="64" /></p>
    <p><label for="area_description">Descripción: </label><textarea id="area_description" name="description" cols="50" rows="5"><?php echo $this->area->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear area" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
