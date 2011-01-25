<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="export_extension">Formato de archivo (*): </label><select id="export_extension" name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></p>
    <p><label>Atributos que desea exportar: </label>&nbsp;</p>
<?php foreach ($this->tests as $test) { ?>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="<?= $test->key ?>" /></span> <span class="form"><span class="mark"><?= $test->key ?></span> <?= $test->label ?></span></p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Exportar calificaciones" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>

