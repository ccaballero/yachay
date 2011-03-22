<p>Para importar materias se toman en cuenta las siguientes filas:</p>
<ul>
    <li>Código (Imprescindible)</li>
    <li>Materia (Imprescindible)</li>
    <li>Moderador (Debe tener permiso de moderador)</li>
    <li>Visibilidad (Los valores posibles son 'public', 'register', 'private', el valor por omision es 'private')</li>
    <li>Descripción</li>
</ul>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="file">Archivo (.csv) (2 MiB max.) (*): </label><?= $this->formFile('file') ?></p>
    <?php $first = true; ?>
<?php foreach ($this->options as $key => $option) { ?>
    <p><label>&nbsp;</label><span><input type="radio" <?= $first ? 'checked="checked" ':'' ?>name="type" value="<?= $key ?>" /></span> <span class="form"><?= $option ?></span></p>
    <?php $first = false; ?>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Importar materias" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
