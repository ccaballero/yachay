<p>Para importar la asignación de usuarios se toman en cuenta las siguientes filas:</p>
<ul>
    <li>Código o Usuario (Imprescindible)</li>
    <li>Cargo (Si no se especifica, se usa el cargo especificado mas abajo)</li>
</ul>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="file">Archivo (.csv) (2 MiB max.) (*): </label><?= $this->formFile('file') ?></p>
    <p><label for="assignement">Cargo: </label><?= $this->assignement(NULL, NULL, NULL, 'type') ?></p>
    <p><label for="include">Incluir tambien en la materia: </label><input type="checkbox" name="include" value="yes" checked="checked" /></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Importar miembros" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
