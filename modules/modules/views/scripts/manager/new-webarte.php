<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="file">Archivo (.zip) (2 MiB max.) (*): </label><?= $this->formFile('file') ?></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Instalar modulo" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
