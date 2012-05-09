<h1><?php echo $this->page->label ?>: Grupo <?php echo $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="export_extension">Formato de archivo (*): </label><select id="export_extension" name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></p>
    <p><label>Atributos que desea exportar: </label>&nbsp;</p>
<?php foreach ($this->tests as $test) { ?>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="<?php echo $test->key ?>" /></span> <span class="form"><span class="mark"><?php echo $test->key ?></span> <?php echo $test->label ?></span></p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Exportar calificaciones" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>

