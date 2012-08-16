<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="export_extension">Formato de archivo (*): </label><select id="export_extension" name="extension"><option>--------------------------</option><option value="csv">.csv (Archivo separado por comas)</option></select></p>
    <p><label>Atributos que desea exportar: </label>&nbsp;</p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="code" /></span> <span class="form"><?php echo $this->model_subjects->_mapping['code'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="moderator" /></span> <span class="form"><?php echo $this->model_subjects->_mapping['moderator'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="label" /></span> <span class="form"><?php echo $this->model_subjects->_mapping['label'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="visibility" /></span> <span class="form"><?php echo $this->model_subjects->_mapping['visibility'] ?></span></p>
    <p><label>&nbsp;</label><span><input type="checkbox" checked="checked" name="columns[]" value="description" /></span> <span class="form"><?php echo $this->model_subjects->_mapping['description'] ?></span></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Exportar materias" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
