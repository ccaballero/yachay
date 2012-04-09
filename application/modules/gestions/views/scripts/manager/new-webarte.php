<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label>Gestión (*): </label><input type="text" name="label" size="15" maxlength="64" value="<?php echo $this->gestion->label ?>" /></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear gestion" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
