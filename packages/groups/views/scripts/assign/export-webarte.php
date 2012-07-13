<h1>Exportar miembros: Grupo <?php echo $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />
    <p><label for="export_extension">Formato de archivo (*): </label><select id="export_extension" name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Exportar miembros" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
