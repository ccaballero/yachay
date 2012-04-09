<p>Para importar la asignación de usuarios se toman en cuenta las siguientes filas:</p>
<ul>
    <li>Código o Usuario (Imprescindible)</li>
    <li>Cargo (Si no se especifica, se usa el cargo especificado mas abajo)</li>
</ul>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="file">Archivo (.csv) (2 MiB max.) (*): </label><?php echo $this->formFile('file') ?></p>
    <p><label for="assignement">Cargo: </label><?php echo $this->assignement(NULL, 'type') ?></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Importar miembros" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
