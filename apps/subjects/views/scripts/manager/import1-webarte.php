<p>Para importar materias se toman en cuenta las siguientes filas:</p>
<ul>
    <li>Código (Imprescindible)</li>
    <li>Materia (Imprescindible)</li>
    <li>Moderador (Debe tener permiso de moderador)</li>
    <li>Visibilidad (Los valores posibles son 'public', 'register', 'private', el valor por omision es 'private')</li>
    <li>Descripción</li>
</ul>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="file">Archivo (.csv) (2 MiB max.) (*): </label><?php echo $this->formFile('file') ?></p>
    <?php $first = true; ?>
<?php foreach ($this->options as $key => $option) { ?>
    <p><label>&nbsp;</label><span><input type="radio" <?php echo $first ? 'checked="checked" ':'' ?>name="type" value="<?php echo $key ?>" /></span> <span class="form"><?php echo $option ?></span></p>
    <?php $first = false; ?>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Importar materias" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
